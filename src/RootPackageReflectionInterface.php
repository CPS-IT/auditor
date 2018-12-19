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

namespace CPSIT\Conductor;


interface RootPackageReflectionInterface
{
    /**
     * Properties which will be reflected
     */
    public const SUPPORTED_PACKAGE_PROPERTIES = [
        'aliases',
        'minimumStability',
        'stabilityFlags',
        'references',
        'preferStable',
        'config',
        'scripts',
        'repositories',
        'license',
        'keywords',
        'description',
        'homepage',
        'authors',
        'support',
        'name',
        'prettyName',
        'names',
        'id',
        'type',
        'targetDir',
        'extra',
        'installationSource',
        'sourceType',
        'sourceUrl',
        'sourceReference',
        'sourceMirrors',
        'distType',
        'distUrl',
        'distUrls',
        'distReference',
        'distSha1Checksum',
        'distMirrors',
        'version',
        'fullPrettyVersion',
        'releaseDate',
        'conflicts',
        'provides',
        'replaces',
        'suggests',
        'autoload',
        'devAutoload',
        'includePaths',
        'repository',
        'uniqueName',
        'notificationUrl'
    ];
}
