<?php

declare(strict_types=1);

/**
 * Copyright 1999-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * Wraps mikepultz/netdns2 for PTR lookups. Takes a NetDNS2\Resolver in
 * constructor for performing reverse DNS queries.
 *
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package  Nls
 */

namespace Horde\Nls\Dns;

use NetDNS2\Resolver;
use NetDNS2\Exception as NetDnsException;

class NetDns2Resolver implements ResolverInterface
{
    public function __construct(
        private readonly Resolver $resolver,
    ) {}

    public function reverse(string $ip): ?string
    {
        try {
            $response = $this->resolver->query($ip, 'PTR');
            foreach ($response->answer as $record) {
                if (isset($record->ptrdname)) {
                    return $record->ptrdname;
                }
            }
        } catch (NetDnsException) {
        }

        return null;
    }
}
