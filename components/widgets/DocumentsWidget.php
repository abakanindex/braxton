<?php
namespace app\components\widgets;

use app\models\Contacts;
use app\models\Document;
use app\models\Rentals;
use app\models\Sale;
use yii\base\Widget;
use yii\helpers\Url;
use app\components\widgets\DocumentsWidgetAsset;

class DocumentsWidget extends Widget
{
    public $model;
    public $ref;
    public $documents;
    public $keyType;
    public $documentCategories;

    public function init()
    {
        $this->documents = Document::getByRef($this->ref);

        if ($this->keyType == Document::KEY_TYPE_SALE) {
            $listing = Sale::findOne(['ref' => $this->ref]);
            $contactType = $listing->contact->contact_type;
        } else if ($this->keyType == Document::KEY_TYPE_RENTAL) {
            $listing = Rentals::findOne(['ref' => $this->ref]);
            $contactType = $listing->contact->contact_type;
        } else if ($this->keyType == Document::KEY_TYPE_CONTACT) {
            $contact = Contacts::findOne(['ref' => $this->ref]);
            $contactType = $contact->contact_type;
        }

        if ($this->keyType == Document::KEY_TYPE_LEAD) {
            $this->documentCategories = Document::$documentLeads;
        } else if ($this->keyType == Document::KEY_TYPE_SALE || $this->keyType == Document::KEY_TYPE_RENTAL || $this->keyType == Document::KEY_TYPE_CONTACT) {
            switch($contactType) {
                case Contacts::CONTACT_TYPE_TENANT:
                    $this->documentCategories = Document::$documentTenants;
                    break;
                case Contacts::CONTACT_TYPE_BUYER:
                    $this->documentCategories = Document::$documentBuyers;
                    break;
                case Contacts::CONTACT_TYPE_LANDLORD:
                case Contacts::CONTACT_TYPE_SELLER:
                case Contacts::CONTACT_TYPE_LANDLORD_SELLER:
                    $this->documentCategories = Document::$documentLandlordsSellers;
                    break;
                case Contacts::CONTACT_TYPE_AGENT:
                    $this->documentCategories = Document::$documentAgents;
            }
        }
    }

    public function run()
    {
        DocumentsWidgetAsset::register($this->view);

        return $this->render('documents/documents', [
            'model' => $this->model,
            'urlForm' => Url::to(['documents/create']),
            'ref' => $this->ref,
            'documents' => $this->documents,
            'documentCategories' => $this->documentCategories,
            'keyType' => $this->keyType
        ]);
    }
}