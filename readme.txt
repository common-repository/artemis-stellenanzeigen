=== Artemis Stellenanzeigen ===
Contributors: aveosolutions, okoch
Donate link:
Tags: job, offer, stellenanzeigen, stellenangebote, aveo, solutions, applicant, artemis
Requires at least: 5.2.6
Tested up to: 6.6.1
Requires PHP: 7.2
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fetches job vacancies from the applicant tracking system (ATS) "Artemis" by AVEO Solutions and displays them. Includes a search bar and pagination for easy navigation.

== Description ==
Fetches job vacancies from the applicant tracking system (ATS) "Artemis" by AVEO Solutions and displays them. Includes a search bar and pagination for easy navigation.

KURZANLEITUNG:
Um das Plugin zu verwenden, fügen Sie einfach auf Ihrer Wordpress-Seite den folgenden Shortcode ein: [artemis-stellenanzeigen]
Im Shortcode kann optional die Url Ihrer Schnittstelle angegeben werden: z.B. [artemis-stellenanzeigen url="https://YOUR-ARTEMIS-DOMAIN/GetAktuelleStellenanzeigen"]
Diese Url wird dann gegenüber der Url in der Konfiguration bevorzugt verwendet.

== Changelog ==

= 1.1.1 =
* Updated settings page with enhanced descriptions, caching tips, and a reset button to restore default plugin settings
* Tested with wordpress version 6.6.1

= 1.1.0 =
* It is now possible to show the company logo in the job overview. This can be set in the plugin settings. 

= 1.0.9 =
* Bugfix: Jobtitles with long words didn't break to new line. 
* Instructions updated.
* Tested with wordpress version 5.8 
 
= 1.0.8 =
* Bugfix: Under certain circumstances, if there was a problem with the api-conncection an unhandled warning message appeared.
 
= 1.0.7 =
* Bugfix: When the user clicked on the jobtitle, the details-page always opened in the actual browser-tab, regardless of the tab-setting in the plugin settings.

= 1.0.6 =
* It is now possible to reset the search.
* This update is tested with the latest version of wordpress (5.4.2).
* Bugfix: Everytime the 'search'-Button is pressed the page is now set back to 1.
* Bugfix: Pagination wasn't rendered in a single row.

= 1.0.5 =
* In the plugins settings the user can now choose wether the details-page opens in a new tab or not. 

= 1.0.4 =
* In the plugins settings it is now possible to define a custom message for no database results. 

= 1.0.3 =
* An url can now be specified in plugins shortcode (e.g. [artemis-stellenanzeigen url="https://YOUR-ARTEMIS-DOMAIN/GetAktuelleStellenanzeigen"]). 
If there's no url in the shortcode, the url in the plugin settings is used as fallback.

= 1.0.2 =
* Searchbar can be hidden by user in the plugin settings.
* Pagination gets automatically hidden, if there are 10 or less job offers in the database or the search results.  

= 1.0.1 =
* Short Description can be hidden by user in the plugin settings.
 
