# Remove Unused Shortcodes

<p>This plugin allows you to remove unused shortcodes from your WordPress blog/site easily without having to go through the process of editing posts and pages to remove them and update.</p>

<p>What it does is it registers these shortcodes to become recognized by WordPress, with an empty output.</p>

<p>Insert each shortcode you want to remove per line in the following settings. Make sure to insert the shortcode handle name only and not the shortcode as being used in the front-end, here are couple examples:</p>

<li>[remove_dis]OK.[/remove_dis] => the shortcode name here is <code>remove_dis</code></li>
<li>[youtube_stats video=s57dlW-5qW4] => the shortcode name is <code>youtube_stats</code></li>

<p>If you need more help open a new issue on the project Github page - <a href="https://github.com/elhardoum/remove-unused-shortcodes">https://github.com/elhardoum/remove-unused-shortcodes</a>