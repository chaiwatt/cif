<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function isDateValid()
    {
        $dates = [
            '5/1/1995',
'1/16/1995',
'5/1/1995',
'5/2/1995',
'5/3/1995',
'5/4/1995',
'5/5/1995',
'5/6/1995',
'5/7/1995',
'5/8/1995',
'5/9/1995',
'5/10/1995',
'5/11/1995',
'5/12/1995',
'5/13/1995',
'5/14/1995',
'5/15/1995',
'5/16/1995',
'5/17/1995',
'5/18/1995',
'5/19/1995',
'5/20/1995',
'5/21/1995',
'5/22/1995',
'5/23/1995',
'5/24/1995',
'5/25/1995',
'5/26/1995',
'5/27/1995',
'5/28/1995',
'5/29/1995',
'5/30/1995',
'5/31/1995',
'6/1/1995',
'6/2/1995',
'6/3/1995',
'6/4/1995',
'6/5/1995',
'6/6/1995',
'6/7/1995',
'6/8/1995',
'6/9/1995',
'6/10/1995',
'6/11/1995',
'6/12/1995',
'6/13/1995',
'6/14/1995',
'6/15/1995',
'6/16/1995',
'6/17/1995',
'6/18/1995',
'6/19/1995',
'6/20/1995',
'6/21/1995',
'6/22/1995',
'6/23/1995',
'6/24/1995',
'6/25/1995',
'6/26/1995',
'6/27/1995',
'6/28/1995',
'6/29/1995',
'6/30/1995',
'7/1/1995',
'7/2/1995',
'7/3/1995',
'7/4/1995',
'7/5/1995',
'7/6/1995',
'7/7/1995',
'7/8/1995',
'7/9/1995',
'7/10/1995',
'7/11/1995',
'7/12/1995',
'7/13/1995',
'7/14/1995',
'7/15/1995',
'7/16/1995',
'7/17/1995',
'7/18/1995',
'7/19/1995',
'7/20/1995',
'7/21/1995',
'7/22/1995',
'7/23/1995',
'7/24/1995',
'7/25/1995',
'7/26/1995',
'7/27/1995',
'7/28/1995',
'7/29/1995',
'7/30/1995',
'7/31/1995',
'8/1/1995',
'8/2/1995',
'8/3/1995',
'8/4/1995',
'8/5/1995',
'8/6/1995',
'8/7/1995',
'8/8/1995',
'8/9/1995',
'8/10/1995',
'8/11/1995',
'8/12/1995',
'8/13/1995',
'8/14/1995',
'8/15/1995',
'8/16/1995',
'8/17/1995',
'8/18/1995',
'8/19/1995',
'8/20/1995',
'8/21/1995',
'8/22/1995',
'8/23/1995',
'8/24/1995',
'8/25/1995',
'8/26/1995',
'8/27/1995',
'8/28/1995',
'8/29/1995',
'8/30/1995',
'8/31/1995',
'9/1/1995',
'9/2/1995',
'9/3/1995',
'9/4/1995',
'9/5/1995',
'9/6/1995',
'9/7/1995',
'9/8/1995',
'9/9/1995',
'9/10/1995',
'9/11/1995',
'9/12/1995',
'9/13/1995',
'9/14/1995',
'9/15/1995',
'9/16/1995',
'9/17/1995',
'9/18/1995',
'9/19/1995',
'9/20/1995',
'9/21/1995',
'9/22/1995',
'9/23/1995',
'9/24/1995',
'9/25/1995',
'9/26/1995',
'9/27/1995',
'9/28/1995',
'9/29/1995',
'9/30/1995',
'10/1/1995',
'10/2/1995',
'10/3/1995',
'10/4/1995',
'10/5/1995',
'10/6/1995',
'10/7/1995',
'10/8/1995',
'10/9/1995',
'10/10/1995',
'10/11/1995',
'10/12/1995',
'10/13/1995',
'10/14/1995',
'10/15/1995',
'10/16/1995',
'10/17/1995',
'10/18/1995',
'10/19/1995',
'10/20/1995',
'10/21/1995',
'10/22/1995',
'10/23/1995',
'10/24/1995',
'10/25/1995',
'10/26/1995',
'10/27/1995',
'10/28/1995',
'10/29/1995',
'10/30/1995',
'10/31/1995',
'11/1/1995',
'11/2/1995',
'11/3/1995',
'11/4/1995',
'11/5/1995',
'11/6/1995',
'11/7/1995',
'11/8/1995',
'11/9/1995',
'11/10/1995',
'11/11/1995',
'11/12/1995',
'11/13/1995',
'11/14/1995',
'11/15/1995',
'11/16/1995',
'11/17/1995',
'11/18/1995',
'11/19/1995',
'11/20/1995',
'11/21/1995',
'11/22/1995',
'11/23/1995',
'11/24/1995',
'11/25/1995',
'11/26/1995',
'11/27/1995',
'11/28/1995',
'11/29/1995',
'11/30/1995',
'12/1/1995',
'12/2/1995',
'12/3/1995',
'12/4/1995',
'12/5/1995',
'12/6/1995',
'12/7/1995',
'12/8/1995',
'12/9/1995',
'12/10/1995',
'12/11/1995',
'12/12/1995',
'12/13/1995',
'12/14/1995',
'12/15/1995',
'12/16/1995',
'12/17/1995',
'12/18/1995',
'12/19/1995',
'12/20/1995',
'12/21/1995',
'12/22/1995',
'12/23/1995',
'12/24/1995',
'12/25/1995',
'12/26/1995',
'12/27/1995',
'12/28/1995',
'12/29/1995',
'12/30/1995',
'12/31/1995',
'1/1/1996',
'1/2/1996',
'1/3/1996',
'1/4/1996',
'1/5/1996',
'1/6/1996',
'1/7/1996',
'1/8/1996',
'1/9/1996',
'1/10/1996',
'1/11/1996',
'1/12/1996',
'1/13/1996',
'1/14/1996',
'1/15/1996',
'1/16/1996',
'1/17/1996',
'1/18/1996',
'1/19/1996',
'1/20/1996',
'1/21/1996',
'1/22/1996',
'1/23/1996',
'1/24/1996',
'1/25/1996',
'1/26/1996',
'1/27/1996',
'1/28/1996',
'1/29/1996',
'1/30/1996',
'1/31/1996',
'2/1/1996',
'2/2/1996',
'2/3/1996',
'2/4/1996',
'2/5/1996',
'2/6/1996',
'2/7/1996',
'2/8/1996',
'2/9/1996',
'2/10/1996',
'2/11/1996',
'2/12/1996',
'2/13/1996',
'2/14/1996',
'2/15/1996',
'2/16/1996',
'2/17/1996',
'2/18/1996',
'2/19/1996',
'2/20/1996',
'2/21/1996',
'2/22/1996',
'2/23/1996',
'2/24/1996',
'2/25/1996',
'2/26/1996',
'2/27/1996',
'2/28/1996',
'2/29/1996',
'3/1/1996',
'3/2/1996',
'3/3/1996',
'3/4/1996',
'3/5/1996',
'3/6/1996',
'3/7/1996',
'3/8/1996',
'3/9/1996',
'3/10/1996',
'3/11/1996',
'3/12/1996',
'3/13/1996',
'3/14/1996',
'3/15/1996',
'3/16/1996',
'3/17/1996',
'3/18/1996',
'3/19/1996',
'3/20/1996',
'3/21/1996',
'3/22/1996',
'3/23/1996',
'3/24/1996',
'3/25/1996',
'3/26/1996',
'3/27/1996',
'3/28/1996',
'3/29/1996',
'3/30/1996',
'3/31/1996',
'4/1/1996',
'4/2/1996',
'4/3/1996',
'4/4/1996',
'4/5/1996',
'4/6/1996',
'4/7/1996',
'4/8/1996',
'4/9/1996',
'4/10/1996',
'4/11/1996',
'4/12/1996',
'4/13/1996',
'4/14/1996',
'4/15/1996',
'4/16/1996',
'4/17/1996',
'4/18/1996',
'4/19/1996',
'4/20/1996',
'4/21/1996',
'4/22/1996',
'4/23/1996',
'4/24/1996',
'4/25/1996',
'4/26/1996',
'4/27/1996',
'4/28/1996',
'4/29/1996',
'4/30/1996',
'5/1/1996',
'5/2/1996',
'5/3/1996',
'5/4/1996',
'5/5/1996',
'5/6/1996',
'5/7/1996',
'5/8/1996',
'5/9/1996',
'5/10/1996',
'5/11/1996',
'5/12/1996',
'5/13/1996',
'5/14/1996',
'5/15/1996',
'5/16/1996',
'5/17/1996',
'5/18/1996',
'5/19/1996',
'5/20/1996',
'5/21/1996',
'5/22/1996',
'5/23/1996',
'5/24/1996',
'5/25/1996',
'5/26/1996',
'5/27/1996',
'5/28/1996',
'5/29/1996',
'5/30/1996',
'5/31/1996',
'6/1/1996',
'6/2/1996',
'6/3/1996',
'6/4/1996',
'6/5/1996',
'6/6/1996',
'6/7/1996',
'6/8/1996',
'6/9/1996',
'6/10/1996',
'6/11/1996',
'6/12/1996',
'6/13/1996',
'6/14/1996',
'6/15/1996',
'6/16/1996',
'6/17/1996',
'6/18/1996',
'6/19/1996',
'6/20/1996',
'6/21/1996',
'6/22/1996',
'6/23/1996',
'6/24/1996',
'6/25/1996',
'6/26/1996',
'6/27/1996',
'6/28/1996',
'6/29/1996',
'6/30/1996',
'7/1/1996',
'7/2/1996',
'7/3/1996',
'7/4/1996',
'7/5/1996',
'7/6/1996',
'7/7/1996',
'7/8/1996',
'7/9/1996',
'7/10/1996',
'7/11/1996',
'7/12/1996',
'7/13/1996',
'7/14/1996',
'7/15/1996',
'7/16/1996',
'7/17/1996',
'7/18/1996',
'7/19/1996',
'7/20/1996',
'7/21/1996',
'7/22/1996',
'7/23/1996',
'7/24/1996',
'7/25/1996',
'7/26/1996',
'7/27/1996',
'7/28/1996',
'7/29/1996',
'7/30/1996',
'7/31/1996',
'8/1/1996',
'8/2/1996',
'8/3/1996',
'8/4/1996',
'8/5/1996',
'8/6/1996',
'8/7/1996',
'8/8/1996',
'8/9/1996',
'8/10/1996',
'8/11/1996',
'8/12/1996',
'8/13/1996',
'8/14/1996',
'8/15/1996',
'8/16/1996',
'8/17/1996',
'8/18/1996',
'8/19/1996',
'8/20/1996',
'8/21/1996',
'8/22/1996',
'8/23/1996',
'8/24/1996',
'8/25/1996',
'8/26/1996',
'8/27/1996',
'8/28/1996',
'8/29/1996',
'8/30/1996',
'8/31/1996',
'9/1/1996',
'9/2/1996',
'9/3/1996',
'9/4/1996',
'9/5/1996',
'9/6/1996',
'9/7/1996',
'9/8/1996',
'9/9/1996',
'9/10/1996',
'9/11/1996',
'9/12/1996',
'9/13/1996',
'9/14/1996',
'9/15/1996',
'9/16/1996',
'9/17/1996',
'9/18/1996',
'9/19/1996',
'9/20/1996',
'9/21/1996',
'9/22/1996',
'9/23/1996',
'9/24/1996',
'9/25/1996',
'9/26/1996',
'9/27/1996',
'9/28/1996',
'9/29/1996',
'9/30/1996',
'10/1/1996',
'10/2/1996',
'10/3/1996',
'10/4/1996',
'10/5/1996',
'10/6/1996',
'10/7/1996',
'10/8/1996',
'10/9/1996',
'10/10/1996',
'10/11/1996',
'10/12/1996',
'10/13/1996',
'10/14/1996',
'10/15/1996',
'10/16/1996',
'10/17/1996',
'10/18/1996',
'10/19/1996',
'10/20/1996',
'10/21/1996',
'10/22/1996',
'10/23/1996',
'10/24/1996',
'10/25/1996',
'10/26/1996',
'10/27/1996',
'10/28/1996',
'10/29/1996',
'10/30/1996',
'10/31/1996',
'11/1/1996',
'11/2/1996',
'11/3/1996',
'11/4/1996',
'11/5/1996',
'11/6/1996',
'11/7/1996',
'11/8/1996',
'11/9/1996',
'11/10/1996',
'11/11/1996',
'11/12/1996',
'11/13/1996',
'11/14/1996',
'11/15/1996',
'11/16/1996',
'11/17/1996',
'11/18/1996',
'11/19/1996',
'11/20/1996',
'11/21/1996',
'11/22/1996',
'11/23/1996',
'11/24/1996',
'11/25/1996',
'11/26/1996',
'11/27/1996',
'11/28/1996',
'11/29/1996',
'11/30/1996',
'12/1/1996',
'12/2/1996',
'12/3/1996',
'12/4/1996',
'12/5/1996',
'12/6/1996',
'12/7/1996',
'12/8/1996',
'12/9/1996',
'12/10/1996',
'12/11/1996',
'12/12/1996',
'12/13/1996',
'12/14/1996',
'12/15/1996',
'12/16/1996',
'12/17/1996',
'12/18/1996',
'12/19/1996',
'12/20/1996',
'12/21/1996',
'12/22/1996',
'12/23/1996',
'12/24/1996',
'12/25/1996',
'12/26/1996',
'12/27/1996',
'12/28/1996',
'12/29/1996',
'12/30/1996',
'12/31/1996',
'1/1/1997',
'1/2/1997',
'1/3/1997',
'1/4/1997',
'1/5/1997',
'1/6/1997',
'1/7/1997',
'1/8/1997',
'1/9/1997',
'1/10/1997',
'1/11/1997',
'1/12/1997',
'1/13/1997',
'1/14/1997',
'1/15/1997',
'1/16/1997',
'1/17/1997',
'1/18/1997',
'1/19/1997',
'1/20/1997',
'1/21/1997',
'1/22/1997',
'1/23/1997',
'1/24/1997',
'1/25/1997',
'1/26/1997',
'1/27/1997',
'1/28/1997',
'1/29/1997',
'1/30/1997',
'1/31/1997',
'2/1/1997',
'2/2/1997',
'2/3/1997',
'2/4/1997',
'2/5/1997',
'2/6/1997',
'2/7/1997',
'2/8/1997',
'2/9/1997',
'2/10/1997',
'2/11/1997',
'2/12/1997',
'2/13/1997',
'2/14/1997',
'2/15/1997',
'2/16/1997',
'2/17/1997',
'2/18/1997',
'2/19/1997',
'2/20/1997',
'2/21/1997',
'2/22/1997',
'2/23/1997',
'2/24/1997',
'2/25/1997',
'2/26/1997',
'2/27/1997',
'2/28/1997',
'3/1/1997',
'3/2/1997',
'3/3/1997',
'3/4/1997',
'3/5/1997',
'3/6/1997',
'3/7/1997',
'3/8/1997',
'3/9/1997',
'3/10/1997',
'3/11/1997',
'3/12/1997',
'3/13/1997',
'3/14/1997',
'3/15/1997',
'3/16/1997',
'3/17/1997',
'3/18/1997',
'3/19/1997',
'3/20/1997',
'3/21/1997',
'3/22/1997',
'3/23/1997',
'3/24/1997',
'3/25/1997',
'3/26/1997',
'3/27/1997',
'3/28/1997',
'3/29/1997',
'3/30/1997',
'3/31/1997',
'4/1/1997',
'4/2/1997',
'4/3/1997',
'4/4/1997',
'4/5/1997',
'4/6/1997',
'4/7/1997',
'4/8/1997',
'4/9/1997',
'4/10/1997',
'4/11/1997',
'4/12/1997',
'4/13/1997',
'4/14/1997',
'4/15/1997',
'4/16/1997',
'4/17/1997',
'4/18/1997',
'4/19/1997',
'4/20/1997',
'4/21/1997',
'4/22/1997',
'4/23/1997',
'4/24/1997',
'4/25/1997',
'4/26/1997',
'4/27/1997',
'4/28/1997',
'4/29/1997',
'4/30/1997',
'5/1/1997',
'5/2/1997',
'5/3/1997',
'5/4/1997',
'5/5/1997',
'5/6/1997',
'5/7/1997',
'5/8/1997',
'5/9/1997',
'5/10/1997',
'5/11/1997',
'5/12/1997',
'5/13/1997',
'5/14/1997',
'5/15/1997',
'5/16/1997',
'5/17/1997',
'5/18/1997',
'5/19/1997',
'5/20/1997',
'5/21/1997',
'5/22/1997',
'5/23/1997',
'5/24/1997',
'5/25/1997',
'5/26/1997',
'5/27/1997',
'5/28/1997',
'5/29/1997',
'5/30/1997',
'5/31/1997',
'6/1/1997',
'6/2/1997',
'6/3/1997',
'6/4/1997',
'6/5/1997',
'6/6/1997',
'6/7/1997',
'6/8/1997',
'6/9/1997',
'6/10/1997',
'6/11/1997',
'6/12/1997',
'6/13/1997',
'6/14/1997',
'6/15/1997',
'6/16/1997',
'6/17/1997',
'6/18/1997',
'6/19/1997',
'6/20/1997',
'6/21/1997',
'6/22/1997',
'6/23/1997',
'6/24/1997',
'6/25/1997',
'6/26/1997',
'6/27/1997',

        ];
        $this->validateDates($dates);
    }
    function validateDates($dates)
    {
        $validDates = [];

        foreach ($dates as $date) {
            $components = explode('/', $date);

            // Check if the date has three components (day, month, year)
            if (count($components) !== 3) {
                return false;
            }

            $day = $components[0];
            $month = $components[1];
            $year = $components[2];

            // Check if the day, month, and year have the correct number of digits
            if (strlen($day) > 2 || strlen($month) > 2 || strlen($year) !== 4) {
                return false;
            }

            // Check if the day, month, and year are numeric
            if (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) {
                return false;
            }

            // Swap day and month if month is greater than 12
            // if ($month > 12) {
            list($day, $month) = [$month, $day];
            // }

            // Validate the day and month values after swapping (if applicable)
            if (strlen($day) > 2 || strlen($month) > 2 || !is_numeric($day) || !is_numeric($month)) {
                return false;
            }

            // Check if the year is greater than 2500
            // if ($year <= 2300) {
            //     return false;
            // }

            $validDate = $day.'/'.$month.'/'.$year;
            echo($validDate . '<br>');
            $validDates[] = $validDate;
        }

        return $validDates;
    }



}
