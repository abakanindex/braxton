<?= $form->field($model, 'property_status')->dropDownList([
        '0' => Yii::t('app', 'Select'),
        'Available' => Yii::t('app', 'Available'),
        'Off-Plan' => Yii::t('app', 'Off-Plan'),
        'Pending' => Yii::t('app', 'Pending'),
        'Reserved' => Yii::t('app', 'Reserved'),
        'Sold' => Yii::t('app', 'Sold'),
        'Upcoming' => Yii::t('app', 'Upcoming'),
    ]);
?>


<?= $form->field($model, 'source_listing')->dropDownList([
        '0' => Yii::t('app', 'Select'),
        '7 days' => Yii::t('app', '7 days'),
        'Abu Dhabi week' => Yii::t('app', 'Abu Dhabi week'),
        'abudhabi.classonet.com' => Yii::t('app', 'abudhabi.classonet.com'),
        'Agent' => Yii::t('app', 'Agent'),
        'Agent External' => Yii::t('app', 'Agent External'),
        'Agent Internal' => Yii::t('app', 'Agent Internal'),
        'Al Ayam' => Yii::t('app', 'Al Ayam'),
        'Al Bayan' => Yii::t('app', 'Al Bayan'),
        'Al Futtaim' => Yii::t('app', 'Al Futtaim'),
        'Al Ittihad News paper' => Yii::t('app', 'Al Ittihad News paper'),
        'Al Khaleej' => Yii::t('app', 'Al Khaleej'),
        'Al Rai' => Yii::t('app', 'Al Rai'),
        'AL Watan' => Yii::t('app', 'AL Watan'),
        'Arab Times' => Yii::t('app', 'Arab Times'),
        'Asharq Al Awsat' => Yii::t('app', 'Asharq Al Awsat'),
        'Bank Referral' => Yii::t('app', 'Bank Referral'),
        'Bayut.com' => Yii::t('app', 'Bayut.com'),
        'Blackberry SMS' => Yii::t('app', 'Blackberry SMS'),
        'Business Card' => Yii::t('app', 'Business Card'),
        'Client referral' => Yii::t('app', 'Client referral'),
        'Cold Call' => Yii::t('app', 'Cold Call'),
        'Colours TV' => Yii::t('app', 'Colours TV'),
        'Company Email' => Yii::t('app', 'Company Email'),
        'Database' => Yii::t('app', 'Database'),
        'Developer' => Yii::t('app', 'Developer'),
        'Direct Call' => Yii::t('app', 'Direct Call'),
        'Direct Client' => Yii::t('app', 'Direct Client'),
        'Drive around' => Yii::t('app', 'Drive around'),
        'Dubizzle Feature' => Yii::t('app', 'Dubizzle Feature'),
        'Dubizzle.com' => Yii::t('app', 'Dubizzle.com'),
        'Dzooom.com' => Yii::t('app', 'Dzooom.com'),
        'Email campaign' => Yii::t('app', 'Email campaign'),
        'Ertebat' => Yii::t('app', 'Ertebat'),
        'Exhibition Stand' => Yii::t('app', 'Exhibition Stand'),
        'Existing client' => Yii::t('app', 'Existing client'),
        'EzEstate' => Yii::t('app', 'EzEstate'),
        'EzHeights.com' => Yii::t('app', 'EzHeights.com'),
        'Facebook' => Yii::t('app', 'Facebook'),
        'Flyers' => Yii::t('app', 'Flyers'),
        'Forbes Mailer' => Yii::t('app', 'Forbes Mailer'),
        'Friend or Relative' => Yii::t('app', 'Friend or Relative'),
        'Google' => Yii::t('app', 'Google'),
        'Gulf Daily News' => Yii::t('app', 'Gulf Daily News'),
        'Gulf News' => Yii::t('app', 'Gulf News'),
        'Gulf News Mailer' => Yii::t('app', 'Gulf News Mailer'),
        'Gulf Newspaper Freehold' => Yii::t('app', 'Gulf Newspaper Freehold'),
        'Gulf Newspaper Residential' => Yii::t('app', 'Gulf Newspaper Residential'),
        'Gulf Times' => Yii::t('app', 'Gulf Times'),
        'Gulfnews Freehold' => Yii::t('app', 'Gulfnews Freehold'),
        'Gulfpropertyportal.com' => Yii::t('app', 'Gulfpropertyportal.com'),
        'Hut.ae' => Yii::t('app', 'Hut.ae'),
        'Instagram' => Yii::t('app', 'Instagram'),
        'JustProperty.com' => Yii::t('app', 'JustProperty.com'),
        'JustRentals.com' => Yii::t('app', 'JustRentals.com'),
        'JUWAI' => Yii::t('app', 'JUWAI'),
        'Khaleej Times' => Yii::t('app', 'Khaleej Times'),
        'LinkedIn' => Yii::t('app', 'LinkedIn'),
        'Listanza' => Yii::t('app', 'Listanza'),
        'Live Chat' => Yii::t('app', 'Live Chat'),
        'Locanto' => Yii::t('app', 'Locanto'),
        'lookup.ae' => Yii::t('app', 'lookup.ae'),
        'Luxury Square Foot' => Yii::t('app', 'Luxury Square Foot'),
        'LuxuryEstate.com' => Yii::t('app', 'LuxuryEstate.com'),
        'Magazine' => Yii::t('app', 'Magazine'),
        'Memaar TV' => Yii::t('app', 'Memaar TV'),
        'MoneyCamel.com' => Yii::t('app', 'MoneyCamel.com'),
        'National News paper' => Yii::t('app', 'National News paper'),
        'Newsletter' => Yii::t('app', 'Newsletter'),
        'Newspaper advert' => Yii::t('app', 'Newspaper advert'),
        'Not Specified' => Yii::t('app', 'Not Specified'),
        'Oforo.com' => Yii::t('app', 'Oforo.com'),
        'Old Landlord' => Yii::t('app', 'Old Landlord'),
        'Online Banners' => Yii::t('app', 'Online Banners'),
        'Open House' => Yii::t('app', 'Open House'),
        'Open House Flyer' => Yii::t('app', 'Open House Flyer'),
        'Other' => Yii::t('app', 'Other'),
        'Other portal' => Yii::t('app', 'Other portal'),
        'Outdoor Media' => Yii::t('app', 'Outdoor Media'),
        'Personal Referral' => Yii::t('app', 'Personal Referral'),
        'Property Acquisition Department' => Yii::t('app', 'Property Acquisition Department'),
        'Property Finder Premium' => Yii::t('app', 'Property Finder Premium'),
        'Property Inc.' => Yii::t('app', 'Property Inc.'),
        'Property life' => Yii::t('app', 'Property life'),
        'Property Management' => Yii::t('app', 'Property Management'),
        'Property Trader' => Yii::t('app', 'Property Trader'),
        'Property Weekly' => Yii::t('app', 'Property Weekly'),
        'Propertyfinder.ae' => Yii::t('app', 'Propertyfinder.ae'),
        'Propertyonline' => Yii::t('app', 'Propertyonline'),
        'Propertywifi.com' => Yii::t('app', 'Propertywifi.com'),
        'PropSpace MLS' => Yii::t('app', 'PropSpace MLS'),
        'Radio' => Yii::t('app', 'Radio'),
        'Radio Advert' => Yii::t('app', 'Radio Advert'),
        'Referral within company' => Yii::t('app', 'Referral within company'),
        'Relocation' => Yii::t('app', 'Relocation'),
        'rezora.com' => Yii::t('app', 'rezora.com'),
        'Rightmove.co.uk' => Yii::t('app', 'Rightmove.co.uk'),
        'Roadshow' => Yii::t('app', 'Roadshow'),
        'Sandcastles.ae' => Yii::t('app', 'Sandcastles.ae'),
        'School Communicator' => Yii::t('app', 'School Communicator'),
        'Search Engine' => Yii::t('app', 'Search Engine'),
        'Signboard' => Yii::t('app', 'Signboard'),
        'SMS campaign' => Yii::t('app', 'SMS campaign'),
        'Social media Campaign' => Yii::t('app', 'Social media Campaign'),
        'Souq.com' => Yii::t('app', 'Souq.com'),
        'Staff Mailer' => Yii::t('app', 'Staff Mailer'),
        'Twitter' => Yii::t('app', 'Twitter'),
        'Walk-in' => Yii::t('app', 'Walk-in'),
        'Wasset.net' => Yii::t('app', 'Wasset.net'),
        'Website' => Yii::t('app', 'Website'),
        'Whatpricemyhome' => Yii::t('app', 'Whatpricemyhome'),
        'Whatsapp' => Yii::t('app', 'Whatsapp'),
        'Word of Mouth' => Yii::t('app', 'Word of Mouth'),
        'www.propertyportal.ae' => Yii::t('app', 'www.propertyportal.ae'),
        'Youtube' => Yii::t('app', 'Youtube'),
        'Yzer.com' => Yii::t('app', 'Yzer.com'),
        'Zawya Mailer' => Yii::t('app', 'Zawya Mailer'),
        'Zoopla' => Yii::t('app', 'Zoopla'),
    ]);
?>
<?= $form->field($model, 'featured')->dropDownList([
        '0' => Yii::t('app', 'Select'),
        'Yes' => Yii::t('app', 'Yes'),
    ]);
?>
<?= $form->field($model, 'dewa')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'str')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'available')->widget(
        yii\jui\DatePicker::className(),
        [
            'model' => $model,
            'attribute' => 'available',
            'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
            'clientOptions' => [
                'defaultDate' => '01-01-2017',
            ],
            'options' => [
                    'class'=>'form-control',

            ],

        ]
    );
?>
<?= $form->field($model, 'remind')->dropDownList([
        '0' => Yii::t('app', 'Never'),
        '1 day' => Yii::t('app', '1 day'),
        '1 week' => Yii::t('app', '1 week'),
        '2 weeks' => Yii::t('app', '2 weeks'),
        '10 weeks' => Yii::t('app', '10 weeks'),
        '1 month' => Yii::t('app', '1 month'),
        '2 month' => Yii::t('app', '2 month'),
        '3 month' => Yii::t('app', '3 month'),
        '4 month' => Yii::t('app', '4 month'),
        '6 month' => Yii::t('app', '6 month'),
    ]);
?>
<?= $form->field($model, 'key_location')->textInput();

    $form->field($model, 'property')->dropDownList([
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]);
?>
<?= $form->field($model, 'rented_at')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'rented_until')->widget(
        yii\jui\DatePicker::className(),
        [
            'model' => $model,
            'attribute' => 'rented_until',
            'language' => 'ru',
            'dateFormat' => 'dd-MM-yyyy',
            'clientOptions' => [
                'defaultDate' => '01-01-2017',
            ],
            'options' => [
                'class'=>'form-control',
            ],
        ]
    );
?>
<?= $form->field($model, 'maintenance')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'managed')->dropDownList([
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]);
?>
<?= $form->field($model, 'exclusive')->dropDownList([
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]);
?>
<?= $form->field($model, 'invite')->dropDownList([
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]);
?>
<?= $form->field($model, 'poa')->dropDownList([
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]);
?>

