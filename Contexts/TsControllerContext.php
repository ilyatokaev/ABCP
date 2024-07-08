<?php

namespace Contexts;

use Exception;
use Models\Client;
use Models\Complaint;
use Models\Consumption;
use Models\Creator;
use Models\Expert;
use Models\NotificationType;
use Models\Seller;
use Models\Status;
use Templates\Template;

/**
 * Реализуем ValueObject-паттерн, чтобы вынести в сторону формирование контекста, для разгрузки кода метода контроллера
 */
class TsControllerContext
{

    public \Models\Seller $reseller;
    public \Models\Client $client;
    public \Models\Creator $creator;
    public \Models\Expert $expert;
    public \Models\Complaint $complaint;
    public \Models\Consumption $consumption;
    public \Models\NotificationType $notificationType;
    public string $differences;
    public int $differencesTo; // Для совместимости со старым почтовым сервисом
    public \Templates\Template $template;


    /**
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data)
    {

        $this->reseller = Seller::getById((int)$data['resellerId']);
        if (!isset($this->reseller)) {
            throw new Exception("Reseller not found by id={$data['resellerId']}");
        }

        $this->client = Client::getById((int)$data['clientId']);
        if (!isset($this->client)) {
            throw new Exception("Client not found by id={$data['clientId']}");
        }

        $this->creator = Creator::getById((int)$data['creatorId']);
        if (!isset($this->creator)) {
            throw new Exception("Creator not found by id={$data['creatorId']}");
        }

        $this->expert = Expert::getById((int)$data['expertId']);
        if (!isset($this->expert)) {
            throw new Exception("Expert not found by id={$data['expertId']}");
        }

        $this->complaint = Complaint::find($data['complaintId']);
        if (!isset($this->complaint)) {
            throw new Exception("Complaint not found by id={$data['complaintId']}");
        }
        $this->complaint->client = $this->client;
        $this->complaint->reseller = $this->reseller;

        $this->consumption = Consumption::find($data['consumptionId']);
        if (!isset($this->consumption)) {
            throw new Exception("Consumption not found by id={$data['consumptionId']}");
        }

        $this->notificationType = NotificationType::find($data['notificationType']);
        if (!isset($this->notificationType)) {
            throw new Exception("Notification Type not found by id={$data['notificationType']}");
        }


        $this->differences = '';
        switch ($this->notificationType->getName()){

            case 'TYPE_NEW':
                $this->differences = __('NewPositionAdded', null, $this->reseller->getId());
                break;

            case 'TYPE_CHANGE':
                if ( empty($data['differences']['from']) || empty($data['differences']['to']) ) {
                    break;
                }

                $statusFrom = Status::find($data['differences']['from']);
                $statusTo = Status::find($data['differences']['to']);

                $this->differencesTo = (int)$data['differences']['to']; // Для совместимости со старым почтовым сервисом

                if (!isset($statusFrom) || !isset($statusTo)) {
                    break;
                }

                $this->differences = __('PositionStatusHasChanged', [
                    'FROM' => $statusFrom->getName(),
                    'TO'   => $statusTo->getName(),
                ], $this->reseller->getId());

        }

        $this->template = new Template(
            $this->complaint, $this->creator, $this->expert, $this->client, $this->consumption
            , $data['agreementNumber'], $data['date'],$this->differences
        );

    }
}