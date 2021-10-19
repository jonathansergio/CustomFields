<?php

namespace Js\CustomFields\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\DataObject;
use Magento\Framework\DataObjectFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Js\CustomerPersonType\Model\Customer\Attribute\Source\PersonType;
use Js\CustomFields\Api\Data\CustomerApiDataInterface;
use Js\CustomFields\Api\Data\CustomerApiDataInterfaceFactory;

/**
 * Class CustomerApiData
 */
class CustomerApiData extends DataObject implements CustomerApiDataInterface
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CustomerApiDataInterfaceFactory
     */
    private $customerApiDataInterfaceFactory;

    /**
     * CustomerApiData constructor.
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerApiDataInterfaceFactory $customerApiDataInterfaceFactory
     * @param array $data
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerApiDataInterfaceFactory $customerApiDataInterfaceFactory,
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerApiDataInterfaceFactory = $customerApiDataInterfaceFactory;
        parent::__construct($data);
    }


    /**
     * @param string $companyContactPerson
     * @return CustomerApiDataInterface
     */
    public function setCompanyContactPerson($companyContactPerson): CustomerApiDataInterface
    {
        $this->setData(self::COMPANY_CONTACT_PERSON, $companyContactPerson);
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyContactPerson()
    {
        return $this->getData(self::COMPANY_CONTACT_PERSON);
    }

    /**
     * @param int $exempted
     * @return CustomerApiDataInterface
     */
    public function setExempted($exempted): CustomerApiDataInterface
    {
        $this->setData(self::EXEMPTED, $exempted);
        return $this;
    }

    /**
     * @return int
     */
    public function getExempted()
    {
        return $this->getData(self::EXEMPTED);
    }

    /**
     * @param int $personType
     * @return CustomerApiDataInterface
     */
    public function setPersonType($personType): CustomerApiDataInterface
    {
        $this->setData(self::PERSON_TYPE, $personType);
        return $this;
    }

    /**
     * @return int
     */
    public function getPersonType()
    {
        return $this->getData(self::PERSON_TYPE);
    }

    /**
     * @param string $socialName
     * @return CustomerApiDataInterface
     */
    public function setSocialName($socialName): CustomerApiDataInterface
    {
        $this->setData(self::SOCIAL_NAME, $socialName);
        return $this;
    }

    /**
     * @return string
     */
    public function getSocialName()
    {
        return $this->getData(self::SOCIAL_NAME);
    }

    /**
     * @param string $stateRegistration
     * @return CustomerApiDataInterface
     */
    public function setStateRegistration($stateRegistration): CustomerApiDataInterface
    {
        $this->setData(self::STATE_REGISTRATION, $stateRegistration);
        return $this;
    }

    /**
     * @return string
     */
    public function getStateRegistration()
    {
        return $this->getData(self::STATE_REGISTRATION);
    }

    /**
     * @param string $tradeName
     * @return CustomerApiDataInterface
     */
    public function setTradeName($tradeName): CustomerApiDataInterface
    {
        $this->setData(self::TRADE_NAME, $tradeName);
        return $this;
    }

    /**
     * @return string
     */
    public function getTradeName()
    {
        return $this->getData(self::TRADE_NAME);
    }


    /**
     * @param OrderInterface $order
     * @return CustomerApiDataInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getInformation(OrderInterface $order)
    {
        $information = $this->customerApiDataInterfaceFactory->create();
        try {
            $customer = $this->customerRepository->getById($order->getCustomerId());
            $personType = $customer->getCustomAttribute('person_type') ? $customer->getCustomAttribute('person_type')->getValue() : 1;
            $information->setPersonType($personType);
            if ($personType == PersonType::COMPANY) {
                $information->setSocialName($customer->getLastname());
                $information->setTradeName($customer->getFirstname());
                $exempted = $customer->getCustomAttribute('exempted') ? $customer->getCustomAttribute('exempted')->getValue() : 1;
                $information->setExempted($exempted);
                $stateRegistration = $customer->getCustomAttribute('state_registration') ? $customer->getCustomAttribute('state_registration')->getValue() : '';
                $information->setStateRegistration($stateRegistration);
                $contactPerson = $customer->getCustomAttribute('company_contact_person') ? $customer->getCustomAttribute('company_contact_person')->getValue() : '';
                $information->setCompanyContactPerson($contactPerson);
            }

        } catch (\Exception $exception) {
            return $information;
        }
        return $information;
    }
}
