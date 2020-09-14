/******* Edit Element in Listings ******/
var all_elements = [
    "inputAssigned",
    "inputCategory",
    "inputBeds",
    "inputBaths",
    "inputEmirate",
    "inputLocation",
    "inputSub-location",
    "inputUnit",
    "inputType",
    "inputStreet",
    "inputFloor",
    "inputBuilt-up",
    "inputPlot",
    "inputView",
    "inputFurnished",
    "inputParking",
    "inputPriceAED",
    "inputFrequency",
    "inputCheques",
    "inputCommission",
    "inputDeposit",
    "inputPropertyStatus",
    "inputSourceOflisting",
    "inputFeatured",
    "inputDEWANumber",
    "inputSTR",
    "inputNextAvailable",
    "inputRemind",
    "inputKeyLocation",
    "inputPropertyTenanted",
    "inputRentedAt",
    "inputRentedUntil",
    "inputMaintenanceFee",
    "inputManaged",
    "inputExclusive",
    "inputInvite",
    "inputPOA",
    "inputCompletionStatus",
    "inputTenure",
    // Lead ids
    "inputRequirPropertyID1",
    "inputRequirCategory1",
    "inputRequirEmirate1",
    "inputRequirLocation1",
    "inputRequirSub-location1",
    "inputRequirMinBeds1",
    "inputRequirMaxBeds1",
    "inputRequirMinPrice1",
    "inputRequirMaxPrice1",
    "inputRequirMinArea1",
    "inputRequirMaxArea1",
    "inputRequirType1",
    "inputRequirUnit1",
    "inputRequirPropertyID2",
    "inputRequirCategory2",
    "inputRequirEmirate2",
    "inputRequirLocation2",
    "inputRequirSub-location2",
    "inputRequirMinBeds2",
    "inputRequirMaxBeds2",
    "inputRequirMinPrice2",
    "inputRequirMaxPrice2",
    "inputRequirMinArea2",
    "inputRequirMaxArea2",
    "inputRequirType2",
    "inputRequirUnit2",
    "inputRequirPropertyID3",
    "inputRequirCategory3",
    "inputRequirEmirate3",
    "inputRequirLocation3",
    "inputRequirSub-location3",
    "inputRequirMinBeds3",
    "inputRequirMaxBeds3",
    "inputRequirMinPrice3",
    "inputRequirMaxPrice3",
    "inputRequirMinArea3",
    "inputRequirMaxArea3",
    "inputRequirType3",
    "inputRequirUnit3",
    "inputLeadAgent",
    //"inputLeadColorCode",
    "inputLeadType",
    "inputLeadFinance",
    "inputLeadPriority",
    "inputLeadHot",
    "inputLeadSource",
    "inputLeadAgentReferral",
    "inputLeadShare",
    // contacts ids
    "inputContactAssignedTo",
    "inputContactReference",
    "inputContactTitle",
    "inputContactFirstName",
    "inputContactLastName",
    "inputContactGender",
    "inputContactDateBirth",
    "inputContactNationalities",
    "inputContactReligion",
    "inputContactLanguage",
    "inputContactHobbies",
    "inputContactWebsite",
    "inputContactFacebook",
    "inputContactTwitter",
    "inputContactLinkedIn",
    "inputContactGoogle",
    "inputContactInstagram",
    "inputContactWeChat",
    "inputContactSkype",
    "inputContactSource",
    "inputContactCompanyName",
    "inputContactDesignation",
    "inputContactType",
    "inputContactCreatedBy",
    "inputContactMobilePersonal",
    "inputContactPhonePersonal",
    "inputContactEmailPersonal",
    "inputContactMobileWork",
    "inputContactMobileOther",
    "inputContactPhoneWork",
    "inputContactPhoneOther",
    "inputContactEmailWork",
    "inputContactEmailOther",
    "inputContactAddressPersonal",
    "inputContactAddressWork",
    "inputContactFaxPersonal",
    "inputContactFaxWork",
    "inputContactFaxOther"
];

var add_new_element = document.getElementById('add-new-element');
var edit_element = document.getElementById('edit-element');
var save_edit_element = document.getElementById('save-edit-element');
var cancel_edit_element = document.getElementById('cancel-edit-element');

for (var i = 0; i < all_elements.length; i++){
    if(document.getElementById(all_elements[i]) != null)document.getElementById(all_elements[i]).setAttribute('disabled', true);
}

function editElement() {
    add_new_element.classList.add('hidden');
    edit_element.classList.add('hidden');
    save_edit_element.classList.remove('hidden');
    cancel_edit_element.classList.remove('hidden');
    for (var i = 0; i < all_elements.length; i++){
        if(document.getElementById(all_elements[i]) != null)document.getElementById(all_elements[i]).removeAttribute('disabled');
    }
}

function cancelElement() {
    add_new_element.classList.remove('hidden');
    edit_element.classList.remove('hidden');
    save_edit_element.classList.add('hidden');
    cancel_edit_element.classList.add('hidden');
    for (var i = 0; i < all_elements.length; i++){
        if(document.getElementById(all_elements[i]) != null)document.getElementById(all_elements[i]).setAttribute('disabled', true);
    }
}

function saveElement() {
    cancelElement();

    alert("some save ajax request for save listing");
}

function newElement(){
    editElement();
    alert("some save ajax request for NEW listing");
}

add_new_element.addEventListener('click', newElement);

edit_element.addEventListener('click', editElement);

save_edit_element.addEventListener('click', saveElement);

cancel_edit_element.addEventListener('click', cancelElement);

var color_code = document.getElementById('inputLeadColorCode');

function selectetColor() {

}

//color_code.addEventListener('', selectetColor);
