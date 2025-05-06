<?php
    // Function to display stars based on rating and show review count
    function display_rating_and_count($rating, $count) {
        $fullStars = floor($rating); // Number of full stars
        $halfStars = ($rating - $fullStars) >= 0.5 ? 1 : 0; // Half star if rating has a decimal part of 0.5 or more
        $emptyStars = 5 - ($fullStars + $halfStars); // Remaining stars are empty
        $starsHtml = '';
        for ($i = 0; $i < $fullStars; $i++) {
            $starsHtml .= '<span style="color: #FFA500 !important;">★</span>'; // Full star with color
        }
        if ($halfStars) {
            $starsHtml .= '<span style="color: #FFA500 !important;">★</span>'; // Half star with color
        }
        for ($i = 0; $i < $emptyStars; $i++) {
            $starsHtml .= '<span style="color: #BBBBBB !important;">★</span>'; // Empty star with color
        }
        return $starsHtml . ' (' . number_format($count) . ')';
    }
?>