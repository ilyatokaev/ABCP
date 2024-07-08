<?php

namespace Templates;

class Template
{

    private array $data;

    /**
     * Создает объект шаблона, наполненный данными
     *
     * @param \Models\Complaint $complaint
     * @param \Models\Creator $creator
     * @param \Models\Expert $expert
     * @param \Models\Client $client
     * @param \Models\Consumption $consumption
     * @param string $agreementNumber
     * @param string $date
     * @param string $differences
     * @return Template
     */
    public function __construct(
        \Models\Complaint $complaint,
        \Models\Creator $creator,
        \Models\Expert $expert,
        \Models\Client $client,
        \Models\Consumption $consumption,
        string $agreementNumber,
        string $date,
        string $differences
    )
    {

        $this->data = [
            'COMPLAINT_ID'       => $complaint->getId(),
            'COMPLAINT_NUMBER'   => $complaint->getNumber(),
            'CREATOR_ID'         => $creator->getId(),
            'CREATOR_NAME'       => $creator->getFullName(),
            'EXPERT_ID'          => $expert->getId(),
            'EXPERT_NAME'        => $expert->getFullName(),
            'CLIENT_ID'          => $client->getId(),
            'CLIENT_NAME'        => $client->getFullName(),
            'CONSUMPTION_ID'     => $consumption->getId(),
            'CONSUMPTION_NUMBER' => $consumption->getNumber(),
            'AGREEMENT_NUMBER'   => $agreementNumber,
            'DATE'               => $date,
            'DIFFERENCES'        => $differences,
        ];

    }


    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }


}