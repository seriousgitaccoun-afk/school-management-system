<?php
/**
 * Avatar Helper
 * Generates professional avatar badges with initials instead of images
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Generate Avatar Badge with Initials
 * 
 * @param string $name Full name of the person
 * @param int $size Size of avatar (default 30px)
 * @param bool $show_name Show name next to avatar (default false)
 * @return string HTML avatar badge
 */
if (!function_exists('get_avatar_badge')) {
    function get_avatar_badge($name = 'User', $size = 30, $show_name = false) {
        // Get initials from name
        $parts = explode(' ', trim($name));
        $initials = '';
        
        if (count($parts) >= 2) {
            $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[count($parts) - 1], 0, 1));
        } else {
            $initials = strtoupper(substr($name, 0, 2));
        }
        
        // Generate color based on name (consistent for same name)
        $colors = array(
            '#03a9f3', // Blue
            '#00c292', // Green
            '#ff9800', // Orange
            '#9c27b0', // Purple
            '#f44236', // Red
            '#2196f3', // Light Blue
            '#009688', // Teal
            '#e91e63', // Pink
            '#673ab7', // Deep Purple
            '#ff5722', // Deep Orange
            '#00bcd4', // Cyan
            '#8bc34a'  // Light Green
        );
        
        $hash = 0;
        for ($i = 0; $i < strlen($name); $i++) {
            $hash = ord($name[$i]) + (($hash << 5) - $hash);
        }
        $colorIndex = abs($hash) % count($colors);
        $bgColor = $colors[$colorIndex];
        
        $html = '<span class="avatar-badge" style="
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: ' . $size . 'px;
            height: ' . $size . 'px;
            border-radius: 50%;
            background-color: ' . $bgColor . ';
            color: white;
            font-weight: 600;
            font-size: ' . ($size * 0.35) . 'px;
            font-family: Poppins, sans-serif;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 2px solid white;
            cursor: default;
            flex-shrink: 0;
        " title="' . htmlspecialchars($name) . '">' . $initials . '</span>';
        
        if ($show_name) {
            $html .= ' <span style="margin-left: 8px; font-size: 13px; color: #2b2b2b;">' . htmlspecialchars($name) . '</span>';
        }
        
        return $html;
    }
}

/**
 * Generate Avatar Badge for Table Display
 * Similar to get_avatar_badge but optimized for table cells
 * 
 * @param string $name Full name of the person
 * @param int $size Size of avatar (default 30)
 * @return string HTML avatar badge
 */
if (!function_exists('get_table_avatar')) {
    function get_table_avatar($name = 'User', $size = 30) {
        return get_avatar_badge($name, $size, false);
    }
}

/**
 * Generate Avatar Badge with Name
 * Optimized for displays where name should be shown
 * 
 * @param string $name Full name of the person
 * @param int $size Size of avatar (default 30)
 * @return string HTML avatar badge with name
 */
if (!function_exists('get_avatar_with_name')) {
    function get_avatar_with_name($name = 'User', $size = 30) {
        return get_avatar_badge($name, $size, true);
    }
}

/**
 * Generate Avatar Badge Group
 * For displaying multiple avatars in a row
 * 
 * @param array $names Array of names
 * @param int $size Size of each avatar (default 30)
 * @param int $max_display Maximum avatars to display (default 5)
 * @return string HTML avatar group
 */
if (!function_exists('get_avatar_group')) {
    function get_avatar_group($names = array(), $size = 30, $max_display = 5) {
        $html = '<div class="avatar-group" style="display: flex; gap: 4px; align-items: center;">';
        
        $count = 0;
        foreach ($names as $name) {
            if ($count >= $max_display) {
                $remaining = count($names) - $max_display;
                $html .= '<span class="avatar-badge" style="
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: ' . $size . 'px;
                    height: ' . $size . 'px;
                    border-radius: 50%;
                    background-color: #9e9e9e;
                    color: white;
                    font-weight: 600;
                    font-size: ' . ($size * 0.35) . 'px;
                    font-family: Poppins, sans-serif;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    border: 2px solid white;
                " title="' . $remaining . ' more">+' . $remaining . '</span>';
                break;
            }
            $html .= get_avatar_badge($name, $size, false);
            $count++;
        }
        
        $html .= '</div>';
        return $html;
    }
}
