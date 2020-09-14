<?php

namespace app\classes;

use app\interfaces\relationShip\iRelationShip;
use app\models\PortalListing;
use app\models\reference_books\Portals;
use app\models\reference_books\PropertyCategory;
use app\models\Rentals;
use app\models\Sale;
use yii\helpers\{ArrayHelper, Json, Url, FileHelper};

class Feed {

    public function returnXml($portalId, $company)
    {
        $xml = "";

        switch($portalId) {
            case Portals::PORTAL_PROPERTY_FINDER:
                $xml = $this->drawPropertyFinder($portalId, $company);
                break;
            case Portals::PORTAL_BAYUT:
                $xml = $this->drawBayut($portalId, $company);
                break;
            case Portals::PORTAL_DUBIZZLE:
                $xml = $this->drawDubizzle($portalId, $company, false);
                break;
            case Portals::PORTAL_DUBIZZLE_UPDATE:
                $xml = $this->drawDubizzle($portalId, $company, true);
                break;
        }

        return $xml;
    }

    private function drawBayut($portalId, $company)
    {
        $items = PortalListing::getForXml(Portals::PORTAL_BAYUT, $company, false);

        $xml = "<Properties>";
        foreach ($items as $i) {
            $xml .= $this->drawBayutItem(
                $i,
                ($i['listingType'] == PortalListing::TYPE_SALE) ? iRelationShip::XML_BAYUT_TYPE_SALE : iRelationShip::XML_BAYUT_TYPE_RENTAL
            );
        }
        $xml .= "</Properties>";

        return $xml;
    }

    private function drawBayutItem($item, $offerType)
    {
        $xml = "\n<Property>
        <Property_Ref_No>
        <![CDATA[" . htmlspecialchars($item['ref']) . "]]>
        </Property_Ref_No>
        <Property_purpose>
        <![CDATA[" . htmlspecialchars($offerType) . "]]>
        </Property_purpose>
        <Property_Type>
        <![CDATA[" . htmlspecialchars($item['property_category_title']) . "]]>
        </Property_Type>
        <Property_Status>
        <![CDATA[" . (($item['status'] == Sale::STATUS_PUBLISHED) ? "live" : "archive") . "]]>
        </Property_Status>
        <City>
        <![CDATA[" . htmlspecialchars($item['region_name']) . "]]>
        </City>
        <Locality>
        <![CDATA[" . htmlspecialchars($item['area_location_name']) . "]]>
        </Locality>
        <Sub_Locality>
        <![CDATA[" . htmlspecialchars($item['sub_area_location_name']) . "]]>
        </Sub_Locality>
        <Property_Title>
        <![CDATA[ " . htmlspecialchars($item['name']) . " ]]>
        </Property_Title>
        <Property_Description>
        <![CDATA[ " . htmlspecialchars($item['description']) . " ]]>
        </Property_Description>
        <Property_Size>
        <![CDATA[" . htmlspecialchars($item['size']) . "]]>
        </Property_Size>
        <Property_Size_Unit>
        <![CDATA[SQFT]]>
        </Property_Size_Unit>
        <Bedrooms>
        <![CDATA[" . (($item['beds'] > 10) ? ("10+") : $item['beds']) . "]]>
        </Bedrooms>
        <Bathroom>
        <![CDATA[" . (($item['baths'] > 10) ? ("10+") : $item['baths']) . "]]>
        </Bathroom>
        <Listing_Agent>
        <![CDATA[" . htmlspecialchars($item['agent_last_name']) . " " . htmlspecialchars($item['agent_first_name']) . "]]>
        </Listing_Agent>
        <Listing_Agent_Phone>
        <![CDATA[" . htmlspecialchars($item['agent_country_dialing']) . htmlspecialchars($item['agent_mobile_no']) . "]]>
        </Listing_Agent_Phone>
        <Listing_Agent_Email>
        <![CDATA[" . htmlspecialchars($item['agent_email']) . "]]>
        </Listing_Agent_Email>
        <Permit_Number>
        <![CDATA[" . htmlspecialchars($item['rera_permit']) . "]]>
        </Permit_Number>";

        if ($offerType == iRelationShip::XML_BAYUT_TYPE_SALE) {
            $xml .= "<Price>
            <![CDATA[" . $item['price'] . "]]>
            </Price>";
        } else if ($offerType == iRelationShip::XML_BAYUT_TYPE_RENTAL) {
            if ($item['price']) {
                $price     = $item['price'];
                $priceTerm = 'yearly';
            } else if ($item['price_per_day']) {
                $price     = $item['price_per_day'];
                $priceTerm = 'daily';
            } else if ($item['price_per_week']) {
                $price     = $item['price_per_week'];
                $priceTerm = 'weekly';
            } else if ($item['price_per_month']) {
                $price     = $item['price_per_month'];
                $priceTerm = 'monthly';
            }

            $xml .= "<Price>
            <![CDATA[" . $price . "]]>
            </Price>
            <Rent_Frequency>" . $priceTerm . "</Rent_Frequency>";
        }

        if ($item['imagesPath']) {
            $photos  = explode(",", $item['imagesPath']);
            $baseUrl = str_replace('/web', '', Url::base(true));
            $xml .= "\n<Images>";

            foreach($photos as $photo) {
                if (!strpos($photo, "http://") && !strpos($photo, "https://"))
                    $photoUrl = $baseUrl . $photo;
                else
                    $photoUrl = $photo;
                $xml .= "\n<Image><![CDATA[" . $photoUrl . "]]></Image>";
            }

            $xml .= "\n</Images>";
        }
        $xml .= "\n</Property>\n";

        return $xml;
    }

    private function drawDubizzle($portalId, $company, $isHourlyUpdate)
    {
        $items = PortalListing::getForXml(Portals::PORTAL_DUBIZZLE, $company, $isHourlyUpdate);

        $xml = "<dubizzlepropertyfeed>";
        foreach ($items as $i) {
            $xml .= $this->drawDubizzleItem(
                $i,
                ($i['listingType'] == PortalListing::TYPE_SALE) ? iRelationShip::XML_DUBIZZLE_TYPE_SALE  : iRelationShip::XML_DUBIZZLE_TYPE_RENTAL
            );
        }
        $xml .= "</dubizzlepropertyfeed>";

        return $xml;
    }

    private function drawDubizzleItem($item, $offerType)
    {
        $xml = "<property>
        <type>" . htmlspecialchars($offerType) . "</type>
        <subtype></subtype>
        <status>" . htmlspecialchars(($item['status'] == Sale::STATUS_PUBLISHED) ? "vacant" : "deleted") . "</status>
        <refno>" . htmlspecialchars($item['ref']) . "</refno>
        <title>" . htmlspecialchars($item['name']) . "</title>
        <description>" . htmlspecialchars($item['description']) . "</description>
        <size>" . htmlspecialchars($item['size']) . "</size>
        <sizeunits>SqFt</sizeunits>
        <bedrooms>" . htmlspecialchars($item['beds']) . "</bedrooms>
        <bathrooms>" . htmlspecialchars($item['baths']) . "</bathrooms>
        <contactemail>" . htmlspecialchars($item['agent_email']) . "</contactemail>
        <contactnumber>" . htmlspecialchars($item['agent_country_dialing']) . htmlspecialchars($item['agent_mobile_no']) . "</contactnumber>
        <city>" . htmlspecialchars($item['region_name']) . "</city>
        <locationtext>" . htmlspecialchars($item['area_location_name']) . "</locationtext>
        <lastupdated>" . htmlspecialchars($item['dateupdated']) . "</lastupdated>
        <building>" . htmlspecialchars($item['sub_area_location_name']) . "</building>";

        if ($offerType == iRelationShip::XML_DUBIZZLE_TYPE_RENTAL) {
            if ($item['price_per_month']) {
                $price         = $item['price_per_month'];
                $rentPriceTerm = iRelationShip::XML_DUBIZZLE_RENT_TERM_MONTH;
            } else {
                $price         = $item['price'];
                $rentPriceTerm = iRelationShip::XML_DUBIZZLE_RENT_TERM_YEAR;
            }

            $xml .= "<price>" . htmlspecialchars($price) . "</price>";
            $xml .= "<rentpriceterm>" . htmlspecialchars($rentPriceTerm) . "</rentpriceterm>";
        } else if ($offerType == iRelationShip::XML_DUBIZZLE_TYPE_SALE) {
            $xml .= "<price>" . htmlspecialchars($item['price']) . "</price>";
        }
        $xml .= "<pricecurrency>AED</pricecurrency>";

        if ($item['latitude'] && $item['longitude'])
            $xml .= "<geopoint>" . htmlspecialchars($item['latitude']) . ',' . htmlspecialchars($item['longitude']) . "</geopoint>";

        if ($item['imagesPath']) {
            $photos  = explode(",", $item['imagesPath']);
            $baseUrl = str_replace('/web', '', Url::base(true));
            $xml .= "<photo>";

            $photoData = [];
            foreach($photos as $photo) {
                if (!strpos($photo, "http://") && !strpos($photo, "https://"))
                    $photoUrl = $baseUrl . $photo;
                else
                    $photoUrl = $photo;
                array_push($photoData, $photoUrl);
            }
            $xml .= implode("|", $photoData);

            $xml .= "</photo>";
        }

        $xml .= "</property>";

        return $xml;
    }

    private function drawPropertyFinder($portalId, $company)
    {
        $items             = PortalListing::getForXml(Portals::PORTAL_PROPERTY_FINDER, $company, false);
        $saleInfoMaxUpDate = Sale::getMaxUpdateDateForPortal($portalId, $company);
        $rentalInfoMaxDate = Rentals::getMaxUpdateDateForPortal($portalId, $company);
        $maxSaleUpDate     = strtotime($saleInfoMaxUpDate['dateupdated']);
        $maxRentalUpDate   = strtotime($rentalInfoMaxDate['dateupdated']);
        $maxUpDate         = date("Y-m-d H:i:s", ($maxSaleUpDate > $maxRentalUpDate) ? $maxSaleUpDate : $maxRentalUpDate);

        foreach ($items as $i) {
            $xml .= $this->drawPropertyFinderItem(
                $i,
                ($i['listingType'] == PortalListing::TYPE_SALE) ? iRelationShip::XML_PROPERTY_FINDER_TYPE_SALE : iRelationShip::XML_PROPERTY_FINDER_TYPE_RENTAL
            );
        }

        $xmlRoot = "<list last_update='$maxUpDate' listing_count='" . count($items) . "'>" . $xml;
        $xmlRoot .= "</list>";

        return $xmlRoot;
    }

    private function drawPropertyFinderItem($item, $offerType)
    {
        $xml  = "<property last_update='" . $item['dateupdated'] . "'>";
        $xml .= "<reference_number>" .htmlspecialchars($item['ref'] ) . "</reference_number>";
        $xml .= "<permit_number>" . htmlspecialchars($item['rera_permit']) . "</permit_number>";
        $xml .= "<offering_type>" . $offerType . "</offering_type>";
        $xml .= "<property_type>" . ((isset(PropertyCategory::$shortCodes[$item['property_category_title']])) ? PropertyCategory::$shortCodes[$item['property_category_title']] : "") . "</property_type>";
        $xml .= "<plot_size>" . $item['plot_size'] . "</plot_size>";
        $xml .= "<size>" . $item['size'] . "</size>";
        $xml .= "<bedroom>" .(($item['beds'] > 7) ? ("7+") : $item['beds']) . "</bedroom>";
        $xml .= "<bathroom>" . (($item['baths'] > 7) ? ("7+") : $item['baths']) . "</bathroom>";
        $xml .= "<floor>" . $item['floor_no'] . "</floor>";
        $xml .= "<title_en>" . htmlspecialchars($item['name']) . "</title_en>";
        $xml .= "<description_en>" . htmlspecialchars($item['description']) . "</description_en>";

        $xml .= "<city>" . htmlspecialchars($item['region_name']) . "</city>";
        $xml .= "<community>" . htmlspecialchars($item['area_location_name']) . "</community>";
        $xml .= "<sub_community>" . htmlspecialchars($item['sub_area_location_name']) . "</sub_community>";

        $xml .= "<agent>
        <id>" . $item['agent_id'] . "</id>
        <name>" . htmlspecialchars($item['agent_last_name']) . " " . htmlspecialchars($item['agent_first_name']) . "</name>
        <email>" . htmlspecialchars($item['agent_email']) . "</email>
        <phone>" . htmlspecialchars($item['agent_country_dialing']) . htmlspecialchars($item['agent_mobile_no']) . "</phone>
        </agent>";

        if ($offerType == iRelationShip::XML_PROPERTY_FINDER_TYPE_RENTAL) {
            $xml .= "<price>
                <yearly>" . htmlspecialchars($item['price']) . "</yearly>
                <monthly>" . htmlspecialchars($item['price_per_month']) . "</monthly>
                <weekly>" . htmlspecialchars($item['price_per_week']) . "</weekly>
                <daily>" . htmlspecialchars($item['price_per_day']) . "</daily>
            </price>";
        } else if ($offerType == iRelationShip::XML_PROPERTY_FINDER_TYPE_SALE) {
            $xml .= "<price>" . htmlspecialchars($item['price']) . "</price>";
        }

        if ($item['imagesPath']) {
            $photos  = explode(",", $item['imagesPath']);
            $baseUrl = str_replace('/web', '', Url::base(true));
            $xml .= "<photo>";

            foreach($photos as $photo) {
                if (!strpos($photo, "http://") && !strpos($photo, "https://"))
                    $photoUrl = $baseUrl . $photo;
                else
                    $photoUrl = $photo;
                $xml .= "<url last_updated='' watermark=''>" . $photoUrl . "</url>";
            }

            $xml .= "</photo>";
        }

        $xml .= "</property>";

        return $xml;
    }

}