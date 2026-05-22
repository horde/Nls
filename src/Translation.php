<?php

declare(strict_types=1);

/**
 * Copyright 2010-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */

namespace Horde\Nls;

use Horde\Translation\Autodetect;

/**
 * Translation wrapper for the Horde\Nls package.
 *
 * @author    Jan Schneider <jan@horde.org>
 * @category  Horde
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Nls
 */
class Translation extends Autodetect
{
    /**
     * The translation domain.
     */
    protected static string $domain = 'Horde_Nls';

    /**
     * The absolute PEAR path to the translations for the default gettext handler.
     */
    protected static string $pearDirectory = '@data_dir@';
}
