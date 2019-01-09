<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace CPSIT\Auditor;


interface SettingsInterface
{
    public const PACKAGE_IDENTIFIER = 'cpsit/auditor';
    public const KEY_VENDOR_DIR = 'vendor-dir';
    public const BUNDLE_DESCRIBER_CLASS = 'BundleDescriber';
    public const SOURCE_FOLDER_NAME = 'src';
    public const NAME_SPACE = 'CPSIT\Auditor';
}
