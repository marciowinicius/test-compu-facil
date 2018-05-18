<?php

class CreditCard
{
    var $_number;

    function _check_length($length, $category)
    {
        if ($category == 0) {
            return (($length == 13) || ($length == 16));
        }
        if ($category == 1) {
            return (($length == 16) || ($length == 18) || ($length == 19));
        }
        if ($category == 2) {
            return ($length == 16);
        }
        if ($category == 3) {
            return ($length == 15);
        }
        if ($category == 4) {
            return ($length == 14);
        }

        return 1;
    }

    function IsValid($number = NULL)
    {
        if (!is_null($number))                                  // new validation?
        {
            // clear current object values ... can't set anything until
            // the card number is identified ...

            $this->_number = NULL;
            $this->_error = 'ERROR_NOT_SET';

            $k = strlen($number);

            $value = '';                                            // init copy buffer
            for ($i = 0; $i < $k; $i++)                             // check input
            {
                $c = $number[$i];                                   // grab a character

                if (ctype_digit($c))                                // is a digit?
                    $value .= $c;                                   // yes, save it

                elseif (!ctype_space($c) && !ctype_punct($c)) {
                    $this->_error = 'ERROR_INVALID_CHAR';
                    break;
                }
            }

            /**
             *  Visa = 4XXX - XXXX - XXXX - XXXX
             * MasterCard = 5[1-5]XX - XXXX - XXXX - XXXX
             * Discover = 6011 - XXXX - XXXX - XXXX
             * Amex = 3[4,7]X - XXXX - XXXX - XXXX
             * Diners = 3[0,6,8] - XXXX - XXXX - XXXX
             * Any Bankcard = 5610 - XXXX - XXXX - XXXX
             * JCB =  [3088|3096|3112|3158|3337|3528] - XXXX - XXXX - XXXX
             * Enroute = [2014|2149] - XXXX - XXXX - XXX
             * Switch = [4903|4911|4936|5641|6333|6759|6334|6767] - XXXX - XXXX - XXXX
             */

            $number = $value;

            if ($number[0] == '4') {
                $lencat = 2;
            }
            if ($number[0] == '5') {
                $lencat = 2;
            }
            if ($number[0] == '3') {
                $lencat = 4;
            }
            if ($number[0] == '2') {
                $lencat = 3;
            }

            if (!$this->_check_length(strlen($number), $lencat)) {
                {
                    $this->_error = 'ERROR_INVALID_LENGTH';
                }
            } else {
                $this->_number = $number;
                $this->_error = true;
            }
        } else {
            {
                $this->_error = 'ERROR_INVALID_CHAR';
            }
        }

        return $this->_error;
    }

    function Set($number = NULL)
    {
        if (!is_null($number))                  // anything passed?
            return $this->IsValid($number);     // yes, check/update the number

        $this->_number = NULL;
        $this->_error = 'ERROR_NOT_SET';
        return 'ERROR_NOT_SET';
    }

    // ************************************************************************
    // Description: retrieve the current card number. the number is returned
    //              unformatted suitable for use with submission to payment and
    //              authorization gateways.
    //
    // Parameters:  none
    //
    // Returns:     card number
    // ************************************************************************
    function Get()
    {
        return @$this->_number;
    }

}
