<?php

function getSanitizedAddress($inline = true): string
{
    if ($inline) {
        $address = get_field('contact_address', 'options');
        if (! $address) {
            return '';
        } else {
            $address = $address['address'].' '.$address['postal_code'].' '.$address['city'].' '.$address['country'];

            return $address;
        }
    } else {
        $address = get_field('contact_address', 'options');
        if (! $address) {
            return '';
        } else {
            $address = $address['company'].'<br>'.$address['address'].' '.$address['postal_code'].' '.$address['city'].', '.$address['country'];
            $address = str_replace("\n", '<br>', $address);

            return $address;
        }
    }
}

function getInternationalPhone($field = 'phone'): string
{
    $phone = get_field($field, 'options');
    if (! $phone) {
        return '';
    } else {
        $phone = str_replace([' ', '-', '(', ')', '/'], '', $phone);
        str_starts_with($phone, '0') ? $phone = '+33'.substr($phone, 1) : $phone;

        return $phone;
    }
}

function getPhone($field = 'phone'): string
{
    $phone = get_field($field, 'options');
    if (! $phone) {
        return '';
    } else {
        return $phone;
    }
}

function getEmail(): string
{
    $mail = get_field('email', 'options');
    if (! $mail) {
        return '';
    } else {
        return $mail;
    }
}

function getNavMenu($location)
{
    $nav = (new \Log1x\Navi\Navi)->build($location);

    return $nav->all();
}
