<?php

namespace Js\CustomFields\Api\Data;

/**
 * Interface CustomerApiDataInterface
 */
interface CustomerApiDataInterface
{

    const COMPANY_CONTACT_PERSON = 'company_contact_person';
    const EXEMPTED = 'exempted';
    const PERSON_TYPE = 'person_type';
    const SOCIAL_NAME = 'social_name';
    const STATE_REGISTRATION = 'state_registration';
    const TRADE_NAME = 'trade_name';


    /**
     * @param string $companyContactPerson
     * @return CustomerApiDataInterface
     */
    public function setCompanyContactPerson($companyContactPerson) : CustomerApiDataInterface;

    /**
     * @return string
     */
    public function getCompanyContactPerson();

    /**
     * @param int $exempted
     * @return CustomerApiDataInterface
     */
    public function setExempted($exempted) : CustomerApiDataInterface;

    /**
     * @return int
     */
    public function getExempted();

    /**
     * @param int $personType
     * @return CustomerApiDataInterface
     */
    public function setPersonType($personType) : CustomerApiDataInterface;

    /**
     * @return int
     */
    public function getPersonType();

    /**
     * @param string $socialName
     * @return CustomerApiDataInterface
     */
    public function setSocialName($socialName) : CustomerApiDataInterface;

    /**
     * @return string
     */
    public function getSocialName();

    /**
     * @param string $stateRegistration
     * @return CustomerApiDataInterface
     */
    public function setStateRegistration($stateRegistration) : CustomerApiDataInterface;

    /**
     * @return string
     */
    public function getStateRegistration();


    /**
     * @param string $tradeName
     * @return CustomerApiDataInterface
     */
    public function setTradeName($tradeName) : CustomerApiDataInterface;

    /**
     * @return string
     */
    public function getTradeName();


}
