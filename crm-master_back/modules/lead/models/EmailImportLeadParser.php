<?php

namespace app\modules\lead\models;


use app\components\Notification;
use app\models\Company;
use app\models\EmailImportLead;
use app\models\Leads;
use app\models\Locations;
use app\models\ref\Ref;
use app\models\reference_books\ContactSource;
use app\models\reference_books\PropertyCategory;
use app\models\Reminder;
use app\models\Rentals;
use app\models\Sale;
use app\models\User;
use Yii;

class EmailImportLeadParser
{
    const SOURCE_FROM_SUBJECT_MAP = [
        [
            'from' => 'bayut',
            'subject' => 'Bayut Rental Inquiry'
        ],
        [
            'from' => 'bayut',
            'subject' => 'Lead Notification: CALL Received'
        ],
        [
            'from' => 'dubizzle',
            'subject' => 'someone is interested'],
        [
            'from' => 'propertyfinder',
            'subject' => 'Contact Kensington Exclusive Properties'
        ]
    ];

    //const LEAD_SUBJECTS = ['dubizzle - someone is interested', 'Bayut Rental Inquiry'];

    const SUBJECT_DUBIZZLE       = 'dubizzle - someone is interested';
    const SUBJECT_BAYUT          = 'Bayut Rental Inquiry';
    const SUBJECT_PROPERTYFINDER = 'propertyfinder.ae - Contact';

    public static function checkEmail()
    {
        $users      = User::getUserEnableImap();
        $tableLeads = Leads::tableName();

        foreach($users as $user) {
            $companyId        = $user->company_id;
            $myBox            = imap_open("{" . $user->imap . "/imap/ssl}", $user->imap_email, $user->imap_password);
            $countEmail       = imap_num_msg($myBox);
            $i                = 0;
            $uids             = [];

            if ($countEmail > 0) {
                while ($i++ < $countEmail) {
                    $overview = imap_fetch_overview($myBox, $i);

                    if ($overview[0]->uid <= $user->emailImportLead->last_checked_uid)
                        continue;

                    $uids[]   = $overview[0]->uid;

                    if (stripos($overview[0]->subject, self::SUBJECT_DUBIZZLE) !== false) {
                        $regexRef   = '/ref no:.[\S]*/mi';
                        $regexPhone = '/telephone:.[ +0-9\S]*/mi';
                        $regexEmail = '/email:.[\S]*@[\S\.]*\.[a-z]*/im';
                        $regexName  = '/name:.[ a-zA-Z\S]*/mi';
                        $message    = imap_fetchbody($myBox, $overview[0]->uid, '1', FT_UID);
                        $matchesRef = $matchesPhone = $matchesEmail = $matchesName = [];
                        $leadSource = ContactSource::SOURCE_DUBIZZLE;

                        preg_match($regexRef, $message, $matchesRef);
                        preg_match($regexPhone, $message, $matchesPhone);
                        preg_match($regexEmail, $message, $matchesEmail);
                        preg_match($regexName, $message, $matchesName);

                        $listingRef = $matchesRef[0];
                        $name       = $matchesName[0];
                        $phone      = $matchesPhone[0];
                        $email      = $matchesEmail[0];

                        $posListingRef = stripos($listingRef, 'ref no:');
                        $posName       = stripos($name, 'name:');
                        $posPhone      = stripos($phone, 'telephone:');
                        $posEmail      = stripos($email, 'email:');

                        $listingRefValue = strip_tags(rtrim(ltrim(substr($listingRef, $posListingRef + strlen('ref no:'), strlen($listingRef) - ($posListingRef + strlen('ref no:'))))));
                        $nameValue       = strip_tags(rtrim(ltrim(substr($name, $posName + strlen('name:'), strlen($name) - ($posName + strlen('name:'))))));
                        $phoneValue      = strip_tags(rtrim(ltrim(substr($phone, $posPhone + strlen('telephone:'), strlen($phone) - ($posPhone + strlen('telephone:'))))));
                        $emailValue      = strip_tags(rtrim(ltrim(substr($email, $posEmail + strlen('email:'), strlen($email) - ($posEmail + strlen('email:'))))));

                        $nameArray = explode(" ", $nameValue);
                        $countAr   = count($nameArray);
                        $lastName  = "";
                        for($j = 1; $j < $countAr; $j++) {
                            $lastName .= $nameArray[$j] . (($j = $countAr - 1 ) ? '' : ' ');
                        }

                        if ($emailValue || $phoneValue)
                            $query .= "insert into `$tableLeads` (`first_name`, `last_name`, `email`, `mobile_number`, `listing_ref`, `source`, `company_id`)
                        values ('$nameArray[0]', '$lastName', '$emailValue', '$phoneValue', '$listingRefValue', '$leadSource', '$companyId');";
                    } else if (stripos($overview[0]->subject, self::SUBJECT_BAYUT) !== false) {
                        $regexName  = '/name:.[ a-zA-Z\S]*/mi';
                        $regexEmail = '/email:.[\S]*@[\S\.]*\.[a-z]*/im';
                        $regexPhone = '/phone:.[ +0-9\S]*/mi';
                        $regexRef   = '/reference:.[\S]*/mi';
                        $message    = imap_fetchbody($myBox, $overview[0]->uid, '1', FT_UID);
                        $matchesRef = $matchesPhone = $matchesEmail = $matchesName = [];
                        $leadSource = ContactSource::SOURCE_BAYUT;

                        preg_match($regexRef, $message, $matchesRef);
                        preg_match($regexPhone, $message, $matchesPhone);
                        preg_match($regexEmail, $message, $matchesEmail);
                        preg_match($regexName, $message, $matchesName);

                        $listingRef = $matchesRef[0];
                        $name       = $matchesName[0];
                        $phone      = $matchesPhone[0];
                        $email      = $matchesEmail[0];

                        $posListingRef = stripos($listingRef, 'reference:');
                        $posName       = stripos($name, 'name:');
                        $posPhone      = stripos($phone, 'phone:');
                        $posEmail      = stripos($email, 'email:');

                        $listingRefValue = strip_tags(rtrim(ltrim(substr($listingRef, $posListingRef + strlen('reference:'), strlen($listingRef) - ($posListingRef + strlen('reference:'))))));
                        $nameValue       = strip_tags(rtrim(ltrim(substr($name, $posName + strlen('name:'), strlen($name) - ($posName + strlen('name:'))))));
                        $phoneValue      = strip_tags(rtrim(ltrim(substr($phone, $posPhone + strlen('phone:'), strlen($phone) - ($posPhone + strlen('phone:'))))));
                        $emailValue      = strip_tags(rtrim(ltrim(substr($email, $posEmail + strlen('email:'), strlen($email) - ($posEmail + strlen('email:'))))));

                        $nameArray = explode(" ", $nameValue);
                        $countAr   = count($nameArray);
                        $lastName  = "";
                        for($j = 1; $j < $countAr; $j++) {
                            $lastName .= $nameArray[$j] . (($j = $countAr - 1 ) ? '' : ' ');
                        }

                        if ($emailValue || $phoneValue)
                            $query .= "insert into `$tableLeads` (`first_name`, `last_name`, `email`, `mobile_number`, `listing_ref`, `source`, `company_id`)
                        values ('$nameArray[0]', '$lastName', '$emailValue', '$phoneValue', '$listingRefValue', '$leadSource', '$companyId');";
                    } else if (stripos($overview[0]->subject, self::SUBJECT_PROPERTYFINDER) !== false) {
                        $regexReference = '/[\*]*reference[\*]*:.[\S]*/mi';
                        $regexRef       = '/[\*]*ref[\*]*:.[\S]*/mi';
                        $regexEmail     = '/[\S]*@[\S\.]*\.[a-z]*/im';
                        $regexName      = '/You can respond to.[ \S]*calling or emailing on/mi';
                        $regexPhone     = '/[*][+0-9]{7,}[*]/mi';
                        $message        = imap_fetchbody($myBox, $overview[0]->uid, '1', FT_UID);
                        $matchesRef     = $matchesPhone = $matchesEmail = $matchesName = $matchesReference = [];
                        $leadSource = ContactSource::SOURCE_PROPERTYFINDER;

                        preg_match($regexReference, $message, $matchesReference);
                        preg_match($regexEmail, $message, $matchesEmail);
                        preg_match($regexName, $message, $matchesName);
                        preg_match($regexRef, $message, $matchesRef);
                        preg_match($regexPhone, $message, $matchesPhone);

                        $listingReference = str_replace("*", '', $matchesReference[0]);
                        $listingRef       = str_replace("*", '', $matchesRef[0]);

                        $posListingRef     = stripos($listingRef, 'ref:');
                        $posReference      = stripos($listingReference, 'reference:');

                        $listingRefValue       = strip_tags(rtrim(ltrim(substr($listingRef, $posListingRef + strlen('ref:'), strlen($listingRef) - ($posListingRef + strlen('ref:'))))));
                        $listingRefValue       = str_replace(".", '', $listingRefValue);
                        $listingReferenceValue = strip_tags(rtrim(ltrim(substr($listingReference, $posReference + strlen('reference:'), strlen($listingReference) - ($posReference + strlen('reference:'))))));
                        $listingReferenceValue       = str_replace(".", '', $listingReferenceValue);
                        $emailValue            = str_replace("*", '', $matchesEmail[0]);
                        $nameValue  = str_replace('calling or emailing on', '', str_replace('You can respond to', '', $matchesName[0]));
                        $nameValue  = rtrim(ltrim(str_replace('*', '', $nameValue)));
                        $phoneValue = str_replace("*", '', $matchesPhone[0]);
                        $listingToDb = ($listingReferenceValue) ? $listingReferenceValue : $listingRefValue;

                        $nameArray = explode(" ", $nameValue);
                        $countAr   = count($nameArray);
                        $lastName  = "";
                        for($j = 1; $j < $countAr; $j++) {
                            $lastName .= $nameArray[$j] . (($j = $countAr - 1 ) ? '' : ' ');
                        }

                        if ($emailValue || $phoneValue)
                            $query .= "insert into `$tableLeads` (`first_name`, `last_name`, `email`, `mobile_number`, `listing_ref`, `source`, `company_id`)
                        values ('$nameArray[0]', '$lastName', '$emailValue', '$phoneValue', '$listingToDb', '$leadSource', '$companyId');";
                    }
                }

                $emailImportLead = ($user->emailImportLead) ? $user->emailImportLead : new EmailImportLead();
                $emailImportLead->email            = $user->imap_email;
                $emailImportLead->imap             = $user->imap;
                $emailImportLead->user_id          = $user->id;
                $emailImportLead->last_checked_uid = ($uids) ? max($uids) : $user->emailImportLead->last_checked_uid;
                $emailImportLead->port             = ($user->imap_port) ? $user->imap_port : "";
                $emailImportLead->password         = $user->imap_password;
                $emailImportLead->status           = $user->imap_enabled;
                $emailImportLead->save();

                if($query)
                    Yii::$app->db->createCommand($query);
            }
        }
    }


    public static function checkNewEmails($emailImportLead)
    {
        try {
            $inbox = imap_open('{' . $emailImportLead->imap . '/imap/ssl}', $emailImportLead->email, $emailImportLead->password);
        } catch (Exception $e) {
            echo "Exception!";
            return;
        }
        $sourceId = 0;
        $uids = [];
        foreach (self::SOURCE_FROM_SUBJECT_MAP as $sourceFromSubject) {
            $emails = imap_search($inbox,
                'SUBJECT "' . $sourceFromSubject['subject'] . '" TEXT "' . $sourceFromSubject['from'] . '"', SE_UID);
            $oldEmails = $emails;
            $emails = [];
            foreach ($oldEmails as $email) {
                if ($email > $emailImportLead->last_checked_uid) {
                    $emails[] = $email;
                }
            }
            if (count($emails) > 0) {
                rsort($emails);
                foreach ($emails as $mail) {
                    $overview = imap_fetch_overview($inbox, $mail, SE_UID)[0];
                    $lead = new Leads();
                    $lead = self::chooseWebsiteParse($lead, $sourceId, $inbox, $overview);
                    $leadChanged = false;
                    foreach ($lead->attributes as $attribute => $val) {
                        if (!empty($val))
                            $leadChanged = true;
                    }
                    if ($leadChanged) {
                        self::saveLead($lead);
                    }
                    $uids[] = $overview->uid;
                }
            }
            $sourceId++;
        }
        if (count($uids) > 0) {
            $emailImportLead->last_checked_uid = max($uids);
            $emailImportLead->save();
        }
        imap_close($inbox);
    }

    private static function chooseWebsiteParse($lead, $sourceId, $inbox, $overview)
    {
        switch ($sourceId) {
            case '0':  // 'from' => 'bayut', 'subject' => 'Bayut Rental Inquiry'
                $message = imap_fetchbody($inbox, $overview->uid, '2', FT_UID);
                $message = quoted_printable_decode($message);
                $emailHtml = \phpQuery::newDocumentHTML($message);
                $content = $emailHtml->find(".msg_desc")->html();
                $fullName = self::get_string_between($content, 'Name: ', '<br>');
                $fullName = self::split_fullname($fullName);
                $lead->first_name = $fullName[0];
                $lead->last_name = $fullName[1];
                $lead->email = self::get_string_between($content, 'Email: ', '<br>');
                $lead->mobile_number = self::get_string_between($content, 'Phone: ', '<br>');
                $lead->emailImportLeadRef = self::get_string_between($content, 'about your property Bayut - ', '.');
                break;
            case '1':  // 'from' => 'bayut', 'subject' => 'Lead Notification: CALL Received'
                $message = imap_fetchbody($inbox, $overview->uid, '1', FT_UID);
                $message = base64_decode($message);
                $emailHtml = \phpQuery::newDocumentHTML($message);
                $content = $emailHtml->find(".innertbl")->html();
                $lead->mobile_number = self::get_string_between($content, 'href="tel:', '"');
                break;
            case '2':  // 'from' => 'dubizzle', 'subject' => 'someone is interested'
                $message = imap_fetchbody($inbox, $overview->uid, '1', FT_UID);
                $message = base64_decode($message);
                $emailHtml = \phpQuery::newDocumentHTML($message);
                $content = $emailHtml->find(".mobile_link")->parents('tr')->html();
                $lead->emailImportLeadRef = self::get_string_between($content, '<strong>Ref No</strong>: ', '<br');
                $lead->first_name = self::get_string_between($content, '<strong>Name</strong>: ', '<br>');
                $lead->mobile_number = $emailHtml->find(".mobile_link a")->text();
                $lead->email = self::get_string_between($content, '<strong>Email</strong>: ', '<br>');
                $lead->notes = self::get_string_between($content, '<strong>Message</strong>: ', '<br>');
                break;
            case '3':  // 'from' => 'propertyfinder', 'subject' => 'Contact Kensington Exclusive Properties'
                $message = imap_fetchbody($inbox, $overview->uid, '1', FT_UID);
                $message = base64_decode($message);
                $emailHtml = \phpQuery::newDocumentHTML($message);
                $content = $emailHtml->find("td.bodyContainer")->html();
                $emailImportLeadRef = self::get_string_between($content, '<strong>Reference</strong>:', '<br');
                $lead->emailImportLeadRef = \phpQuery::newDocumentHTML($emailImportLeadRef)->find('a')->text();
                $lead->email = $emailHtml->find("td.bodyContainer")->find('.senderEmail')->text();
                $lead->mobile_number = $emailHtml->find("td.bodyContainer")->find('.senderPhone')->text();
                $fullName = $emailHtml->find("td.bodyContainer")->find('.senderName')->text();
                $fullName = self::split_fullname($fullName);
                $lead->first_name = $fullName[0];
                $lead->last_name = $fullName[1];
                print_r($lead->attributes);
                break;
        }
        return $lead;
    }

    private static function parseJustproperty($lead, $emailHtml)
    {
        $fullName = $emailHtml->find("span:contains('Name:')")->parents('td')->next()->find('span')->text();
        $fullName = self::split_fullname($fullName);
        $lead->first_name = $fullName[0];
        $lead->last_name = $fullName[1];
        $lead->email = $emailHtml->find("span:contains('Email:')")->parents('td')->next()->find('a > span')->text();
        $enquiry = $emailHtml->find("span:contains('Enquiry:')")->parents('td')->next()->find('span:first')->text();
        if ($enquiry)
            $lead->notes = Yii::t('app', 'Enquiry:') . ' ' . $enquiry;
        $ref = $emailHtml->find("span:contains('Ref')")->text();
        $ref = str_replace("Ref: ", "", $ref);
        $lead->emailImportLeadRef = $ref;
        return $lead;
    }

    private static function saveLead($lead)
    {
        $lead->created_by_user_id = Yii::$app->user->id;
        $lead->company_id = Company::getCompanyIdBySubdomain();
        $lead->updated_time = time();
        $lead->is_imported = Leads::IMPORTED;
        if ($lead->save(false)) {
            $lead->reference = (new Ref())->getRefCompany($lead);
            if ($lead->save(false)) {
                Notification::notify(Notification::KEY_EMAIL_IMPORT_LEAD, Yii::$app->user->id, $lead->id);
                self::saveLeadProperty($lead);
            }
        }
    }

    private static function saveLeadProperty($lead)
    {
        $leadType = explode("-", $lead->emailImportLeadRef);
        if ($leadType[1] == 'S') {
            $sale = Sale::find()->where(['ref' => trim($lead->emailImportLeadRef)])->one();
            if ($sale) {
                $leadProperty = new LeadProperty();
                $leadProperty->property_id = $sale->id;
                $leadProperty->lead_id = $lead->id;
                $leadProperty->type = LeadProperty::TYPE_SALE;
                $leadProperty->save();
            }
        } elseif ($leadType[1] == 'R') {
            $rental = Rentals::find()->where(['ref' => trim($lead->emailImportLeadRef)])->one();
            if ($rental) {
                $leadProperty = new LeadProperty();
                $leadProperty->property_id = $rental->id;
                $leadProperty->lead_id = $lead->id;
                $leadProperty->type = LeadProperty::TYPE_RENTALS;
                $leadProperty->save();
            }
        }
    }

    private static function split_fullname($name)
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . $last_name . '#', '', $name));
        return array($first_name, $last_name);
    }

    private static function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

}