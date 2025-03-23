<?php

namespace App\Services;

use App\Repositories\Contracts\ReservationRepositoryInterface;

class ReservationService
{
    protected $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function createReservation(array $data)
    {
        return $this->reservationRepository->createReservation($data);
    }

    public function confirmReservation($reservationId)
    {
        return $this->reservationRepository->confirmReservation($reservationId);
    }

    public function cancelReservation($reservationId)
    {
        return $this->reservationRepository->cancelReservation($reservationId);
    }
}
