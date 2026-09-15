<?php

namespace Onetoweb\NeDistriService\Util;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Webhook Utils.
 */
final class Webhook
{
    public const ALLOWED_IP = '136.144.175.80';
    
    /**
     * @return bool
     */
    public static function validate(): bool
    {
        $request = Request::createFromGlobals();
        
        if ($request->isMethod('POST')) {
            
            if ($request->getClientIp() === self::ALLOWED_IP) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * @return array|null
     */
    public static function data(): ?array
    {
        $request = Request::createFromGlobals();
        
        return json_decode($request->getContent(), true);
    }
}
