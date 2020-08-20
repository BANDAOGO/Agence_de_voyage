=== TraveledMap Trip itinerary: Embedded map ===
Contributors: traveledmap
Tags: map, trip, pictures, traveledmap, embed, travel, blog, post, itinerary
Donate link: https://donorbox.org/help-traveledmap-to-stay-free
Requires at least: 3.0.1
Tested up to: 5.2.1
Requires PHP: 5.6
Stable tag: 1.0.9
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create <strong>interactive</strong> blog post thanks to a map moving along your trip's steps while user reads. The map can be customized
to fit your theme.

== Description ==

This plugin will help you to produce more interactive blog posts thanks to a map, <strong>moving along your trip's steps</strong> while user is reading the post.
The map can show your trip pictures, the steps name and is fully customizable to your needs:
You can either include a map thanks to a <strong>widget</strong>, that will be expandable on the screen depending on the options you specify, or
thanks to a map that can be "sticky", i.e it will stay at the top of the screen while user reads the article.
By creating your trip on [TraveledMap](https://www.traveledmap.com/builder "Build your first trip with TraveledMap"), you will be
able to create a brand new type of blog post in a few minutes !
A short demonstration video is worth a thousand words:
<iframe
	width="640" height="360" src="https://youtu.be/lWnCq5VJ3fc"
	frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
</iframe>

=== How does it work ? ===

As explained above, this plugin aims to <strong>improve user experience</strong> by placing a map of your trip on your blog posts.
Once the plugin installed, you will have a new section on the right of the post editor, as explained in the
[Configuration video](https://youtu.be/8ksArmSB-ug)

This section contains four fields:
 - <strong>User id</strong>: This is your TraveledMap user id
 - <strong>Trip id</strong>: This is the id of your trip, created on [TraveledMap](https://www.traveledmap.com "TraveledMap interactive trips")
 - <strong>Disable widget</strong>: It allows to disable the widget on a specific page
 - <strong>Show markers customization</strong>: It allows to see the marker's icon, color and size instead of steps numbers

To get this data, go to the map edition page of TraveledMap, and click the link button, under the name of the trip you want to embed
in your post. It will lead you to the "Embed a trip" page with the needed information.
Once you filled the two field, you need to validate in order to save and to check if the data is valid.
Then don't forget to save the draft.

Once this step done, you will be able to have a map using either a widget or a standard map.

==== Use the widget ====
To use the widget, go to your admin widget management section and add the "TraveledMap Trip" widget.
The widget will include a map showing all the steps of your trip at first, then it will show the different cities or steps
along user's reading.
You can customise the widget using different options:

 - <strong>Show on phones</strong> will decide if the map will appear when a user is visiting the website with a mobile (width <= 576px).
 - <strong>Show on tablets</strong> will decide if the map will appear when a user is visiting the website with a tablet (576px > width <= 768px).
 - <strong>Show on larger screens</strong> will decide if the map will appear when a user is visiting the website with a larger screen than phone or tablet (> 768px).
 - <strong>Map height</strong>: The default map's height when it's not expanded.
 - <strong>Widget is sticky</strong>: If checked, the widget will be sticky to the top of the screen even if he's not expanded. This way, it will follow the user scroll even in reduced size.
 - <strong>When the map is not extended, show steps</strong>: You can decide if the name of your trip's steps will be shown by default or not. If not checked, steps will be shown only when the mouse
 is over the step marker, or the step currently scrolled.
 - <strong>Can be expanded</strong>: Choose whether the widget will keep its default size, or if user will be able to expand its size by clicking a button (like a youtube video)
 - <strong>When the map is extended, show steps</strong>: This is the same option that you can configure for the extended map.
 - <strong>When the map is extended, show pictures</strong>: You can decide that pictures will never be visible. If this option is not checked, the pictures will be visible only if users decide
 to expand the pictures panel, at the bottom of the map.
 - <strong>Extend to top, right, bottom or left</strong>: First, note that those options will work only if you checked the previous one. Choosing extend to top, will resize the map to fit
 the top of the screen when the user click the "extend" button. Moreover, as soon as the button is clicked, the map will be sticky in order to be close to the user
 when he reads the article.
 With 4 options, you can decide to expand the map whereever you want. For example, if the widget is in a sidebar on the right, you can check extend top, right and bottom.
 This way, the map will be "half full sized" on the right and you don't have to change anything to your layout !
 - <strong>Margin top, right, bottom and left</strong>: Margins are used to let some space between the map and the borders of the screen when the map is extended. Most of the time
 expand a map to the borders of the screen will be ugly, that's why you can use margin and make the map fit the spacing of your theme.

**Note** that the widget won't show if your blog post doesn't contain a trip id information (filled in the post editor).

==== use the Standard map ====
If you don't want to use widget, that is the recommanded way to use this plugin for a better user experience, you can use the standard map.
You can place this map everywhere in your article thanks to a **Block** or a **Shortcode**. Its behavior is the same as the widget, it will move along the
location you visited while users is reading your article.
There are multiple options to customise it.

In the "Map content" section:
 - <strong>Show steps name</strong>: You can decide if the name of your trip's steps will be shown by default or not. If not checked, steps will be shown only when the mouse
 is over the step marker, or the step currently scrolled.
 - <strong>Show pictures</strong>: You can decide that pictures will never be visible. If this option is not checked, the pictures will be visible only if users decide
 to expand the pictures panel, at the bottom of the map.
 - <strong>Show overview pictures</strong>: Overview pictures are the pictures you choose as the best pictures of your trip. You can decide to show them or not with this option.

In the "Map settings" section:
 - <strong>Map height</strong> can be defined in pixels (px) or percentage (%) of the screen's height. It will define the height of the map when it's not sticky.
 - <strong>Map is sticky</strong> will decide if the map sticks to the top of the screen while user scroll to read the blog post.
 - <strong>Show on phones</strong> will decide if the map will appear when a user is visiting the website with a mobile (width <= 576px).
 - <strong>Show on tablets</strong> will decide if the map will appear when a user is visiting the website with a tablet (576px > width <= 768px).
 - <strong>Show on larger screens</strong> will decide if the map will appear when a user is visiting the website with a larger screen than phone or tablet (> 768px).
 - <strong>Height of the map in its standard height</strong>: This is the height the map will take. Either you can specify a fixed height with pixels (e.g 300px)
 or you can specify a percentage relative to the screen height (e.g 40%).
 - <strong>Height of the map in its extended height</strong>: Users will be able to choose whether the map is hidden, in standard height or extended height. This option
 corresponds to the size of the expanded height, in pixels or percentage.
 - <strong>Top margin</strong>: As the widget margins, you may want to see space between the map and the top of the screen. This is the way to configure a space.
 The value is in pixels, but you have to omit the "px". For example use "18", NOT "18px"

**Shortcode example**
[embedded_trip show_popup="0" show_pictures="1" show_pictures_at_start="0" map_height="60%" is_sticky="1" show_on_phones="1" show_on_tablets="1" show_on_large_screens="1" standard_map_height="35%" extended_map_height="70%" margin_top="10"]


==== Define when a step should show ====
This step explains how the magic happens...
A you can see in the video above, the map moves from step to step while scrolling the video.
In order to achieve these moves, you have to specify where your steps stands along your article. Don't worry it's easy to do.
Just include a **Embedded Trip step Block** (search for Embedded trip step) or a **Shortcode** and choose the step in the list.
If you don't see any step in the list, please check that your trip has steps and that you pressed the "Validate" button in the editor's right column.

**Shortcode example**
[embedded_trip_step location="vancouver"]
If you're not using block but shortcode, you will have to use locations specified on the "Embed a trip" page, where you found
your user id and trip id.

**Note**: If your trip's steps are not well ordered, you can edit the order on the trip edition page.
You can access this page from the [Share page](https://www.traveledmap.com/share "Embed your Trips on a blog post") too.


=== Pricing ===
The WordPress plugin is free but to embed the map on your posts, I ask for from $0 to $49.99 by month depending on the number
of visits on your site.
You can learn more at [Embed page](https://www.traveledmap.com/pricing "TraveledMap pricing")


== Frequently Asked Questions ==

= How to create a trip? =

To create a trip, go to [traveledmap.com trip editor](https://www.traveledmap.com/builder "Create a new trip") and follow the steps.
It's easy and it won't take time !
If you have a lot of trips to add and you don't want to spend time creating a map, contact me at [contact@traveledmap.com](mailto:contact@traveledmap.com "Contact me")

= I don't see steps in the Embedded trip step block, what's wrong? =
To get the steps in this block, you have to validate your user id an trip id in the right column of the post edit, then save draft
and finally add an Embedded trip step block. If you still have issues, please contact me.

= Why do I have to pay? =

Embedding trips on frequently visited sites and blogs has a cost. TraveledMap tool is totally free, that's why it seems
reasonable to charge for those fees.
If you think you can't handle this pricing, contact me at [contact@traveledmap.com](mailto:contact@traveledmap.com "Contact me")

== Screenshots ==

1. Example - Expanded widget: `/assets/example-1.png`
2. Example - Reduced widget: `/assets/example-2.png`
3. Example - Standard map: `/assets/example-3.png`
4. How to use - metabox: `/assets/metabox.png`
5. How to use - Standard map block: `/assets/trip-block.png`
6. How to use - Widget configuration: `/assets/widget-config.png`

== Changelog ==

= 1.0.0 =
* Creation of the plugin

= 1.0.1 =
* New pictures slider

= 1.0.2 =
* Allow fullscreen

= 1.0.3 =
* Fix bugs

= 1.0.4 =
* Disable widget on specific posts

= 1.0.5 =
* Fix jumping content

= 1.0.6 =
* Improve scrolling with map

= 1.0.7 =
* Improved transitions and zooming. This plugin can now be used on pages

= 1.0.8 =
* Released new version

= 1.0.9 =
* Added an option to show markers customization and fixed a bug concerning loading state

== Upgrade Notice ==
No upgrade to do for the moment
