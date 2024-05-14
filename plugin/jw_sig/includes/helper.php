<?php
/**
 * @version      4.2
 * @package      Simple Image Gallery (plugin)
 * @author       JoomlaWorks - https://www.joomlaworks.net
 * @copyright    Copyright (c) 2006 - 2022 JoomlaWorks Ltd. All rights reserved.
 * @license      GNU/GPL license: https://www.gnu.org/licenses/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class SimpleImageGalleryHelper
{
    public $srcimgfolder;
    public $thb_width;
    public $thb_height;
    public $smartResize;
    public $jpg_quality;
    public $cache_expire_time;
    public $gal_id;
    public $format;

    public function renderGallery()
    {
        // Initialize
        $srcimgfolder = $this->srcimgfolder;
        $thb_width = $this->thb_width;
        $thb_height = $this->thb_height;
        $smartResize = $this->smartResize;
        $jpg_quality = $this->jpg_quality;
        $cache_expire_time = $this->cache_expire_time;
        $gal_id = $this->gal_id;
        $format = $this->format;

        // API
        jimport('joomla.filesystem.folder');

        // Path assignment
        $sitePath = JPATH_SITE.'/';
        if ($format == 'feed') {
            $siteUrl = JURI::root(true).'';
        } else {
            $siteUrl = JURI::root(true).'/';
        }

        // Internal parameters
        $prefix = "jw_sig_cache_";

        // Set the cache folder
        $cacheFolderPath = JPATH_SITE.'/cache/jw_sig';
        if (!file_exists($cacheFolderPath)) {
            mkdir($cacheFolderPath);
        }

        // Check if the source folder exists and read it
        $srcFolder = JFolder::files($sitePath.$srcimgfolder, '\.jpg|\.jpeg|\.png|\.gif|\.webp|\.mp4|\.webm', false, true);

        // Proceed if the folder is OK or fail silently
        if (!$srcFolder) {
            return false;
        }

        // Initialize the gallery array
        $gallery = array();
        foreach ($srcFolder as $srcFile) {
            $ext = strtolower(JFile::getExt($srcFile));
            if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'webm'))) {
                $gallery[] = (object) array(
                    'filename' => basename($srcFile),
                    'sourceImageFilePath' => $siteUrl.str_replace($sitePath, '', $srcFile),
                    'thumbImageFilePath' => $siteUrl.str_replace($sitePath, '', $srcFile),
                    'width' => $thb_width, // Example width
                    'height' => $thb_height, // Example height
                    'is_video' => in_array($ext, array('mp4', 'webm'))
                );
            }
        }

        // Return the gallery array
        return $gallery;
    }

    // Replace white space
    private function replaceWhiteSpace($text_to_parse)
    {
        $source_html = array(" ");
        $replacement_html = array("%20");
        return str_replace($source_html, $replacement_html, $text_to_parse);
    }

    // Cleanup thumbnail filenames
    private function cleanThumbName($text_to_parse)
    {
        $source_html = array(' ', ',');
        $replacement_html = array('_', '_');
        return str_replace($source_html, $replacement_html, $text_to_parse);
    }

    // Path overrides
    public function getTemplatePath($pluginName, $file, $tmpl)
    {
        $app = JFactory::getApplication();
        $template = $app->getTemplate();

        $p = new stdClass;

        if (file_exists(JPATH_SITE.'/templates/'.$template.'/html/'.$pluginName.'/'.$tmpl.'/'.$file)) {
            $p->file = JPATH_SITE.'/templates/'.$template.'/html/'.$pluginName.'/'.$tmpl.'/'.$file;
            $p->http = JURI::root(true)."/templates/".$template."/html/{$pluginName}/{$tmpl}/{$file}";
        } else {
            if (version_compare(JVERSION, '2.5.0', 'ge')) {
                // Joomla 2.5+
                $p->file = JPATH_SITE.'/plugins/content/'.$pluginName.'/'.$pluginName.'/tmpl/'.$tmpl.'/'.$file;
                $p->http = JURI::root(true)."/plugins/content/{$pluginName}/{$pluginName}/tmpl/{$tmpl}/{$file}";
            } else {
                // Joomla 1.5
                $p->file = JPATH_SITE.'/plugins/content/'.$pluginName.'/tmpl/'.$tmpl.'/'.$file;
                $p->http = JURI::root(true)."/plugins/content/{$pluginName}/tmpl/{$tmpl}/{$file}";
            }
        }
        return $p;
    }
}
