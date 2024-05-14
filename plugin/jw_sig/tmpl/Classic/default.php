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
?>

<ul id="sigFreeId<?php echo $gal_id; ?>" class="sigFreeContainer sigFreeClassic<?php echo $extraWrapperClass; ?>">
    <?php foreach($gallery as $count=>$media): ?>
    <li class="sigFreeThumb">
        <?php if ($media->is_video): ?>
        <video width="<?php echo $media->width; ?>" height="<?php echo $media->height; ?>" controls>
            <source src="<?php echo $media->sourceImageFilePath; ?>" type="video/<?php echo pathinfo($media->sourceImageFilePath, PATHINFO_EXTENSION); ?>">
            Your browser does not support the video tag.
        </video>
        <?php else: ?>
        <a href="<?php echo $media->sourceImageFilePath; ?>" class="sigFreeLink<?php echo $extraClass; ?>" style="width:<?php echo $media->width; ?>px;height:<?php echo $media->height; ?>px;" title="<?php echo JText::_('JW_PLG_SIG_YOU_ARE_VIEWING').' '.$media->filename; ?>" data-thumb="<?php echo $media->thumbImageFilePath; ?>" target="_blank"<?php echo $customLinkAttributes; ?>>
            <!-- <img class="<img class="sigFreeImg" src="<?php echo $transparent; ?>" alt="<?php echo JText::_('JW_PLG_SIG_CLICK_TO_ENLARGE_IMAGE').' '.$media->filename; ?>" title="<?php echo JText::_('JW_PLG_SIG_CLICK_TO_ENLARGE_IMAGE').' '.$media->filename; ?>" style="width:<?php echo $media->width; ?>px;height:<?php echo $media->height; ?>px;background-image:url('<?php echo $media->thumbImageFilePath; ?>');" />" src="<?php echo $transparent; ?>" alt="<?php echo JText::_('JW_PLG_SIG_CLICK_TO_ENLARGE_IMAGE').' '.$media->filename; ?>" title="<?php echo JText::_('JW_PLG_SIG_CLICK_TO_ENLARGE_IMAGE').' '.$media->filename; ?>" style="width:<?php echo $media->width; ?>px;height:<?php echo $media->height; ?>px;background-image:url('<?php echo $media->thumbImageFilePath; ?>');" /> -->
            <img class="sigFreeImg" src="<?php echo $transparent; ?>" alt="<?php echo JText::_('JW_PLG_SIG_CLICK_TO_ENLARGE_IMAGE').' '.$media->filename; ?>" title="<?php echo JText::_('JW_PLG_SIG_CLICK_TO_ENLARGE_IMAGE').' '.$media->filename; ?>" style="width:<?php echo $media->width; ?>px;height:<?php echo $media->height; ?>px;background-image:url('<?php echo $media->thumbImageFilePath; ?>');" />
        </a>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
    <li class="sigFreeClear">&nbsp;</li>
</ul>

<?php if($isPrintPage): ?>
<!-- Print output -->
<div class="sigFreePrintOutput">
    <?php foreach($gallery as $count => $media): ?>
    <?php if (!$media->is_video): ?>
    <img src="<?php echo $media->thumbImageFilePath; ?>" alt="<?php echo $media->filename; ?>" />
    <?php if(($count+1)%3 == 0): ?><br /><br /><?php endif; ?>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>
