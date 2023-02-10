<?php

namespace App\Controller\Search;

use App\Entity\Booking;
use App\Repository\BookingRepository;

class BookingSearch
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function search(Booking $booking)
    {
        return $this->bookingRepository->filters($booking);
    }
}