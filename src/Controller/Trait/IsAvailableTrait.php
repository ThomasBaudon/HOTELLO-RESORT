<?php 

namespace App\Controller\Trait;


    trait IsAvailableTrait{

    /**
    * Check if the room is available for a given date range.
    *
    * @param \DateTime $startDate
    * @param \DateTime $endDate
    *
    * @return bool
    */
    
    public function isAvailable(\DateTime $startDate, \DateTime $endDate)
    {
        // Get the bookings for this room
        $bookings = $this->getBookings();

        // Check if any of the bookings overlap with the given date range
        foreach ($bookings as $booking) {
            if ($booking->getStartDate() <= $endDate && $booking->getEndDate() >= $startDate) {
                return false;
            }
        }

        return true;
    }
    
}