# hetznerdyndns
This is a PHP script for using the Hetzner DNS panel as DynDNS platform from any DynDNS Client capable of creating custom update queries. This one does not have to used with own nameserver or zone file.
# Background
I own an own domain, which I liked to use as DynDNS basis instead of using an existing DynDNS service. Either it costs money or has restrictions (like logging in from time to time). My web provider Hetzner provides an [API](https://dns.hetzner.com/api-docs) for handling DNS entries, and I was interested in using this interface for my own purpose. The way, it is designed, cannot be used directly, so some kind of a wrapper is required, which I did in PHP. Thus any DynDNS client could send the update request via HTTP (GET).
# Features
* Turns any IP update into a DNS API request
* Provides setup routines for a IPv4 and IPv6 at the same time
# Requirements
* You need a webserver with PHP support (preferably outside your LAN; inside you may encounter issues with https connections)
* PHP should be enabled for CURL and local file storage
# Installation
* Copy the files/directories to a suitable location on your webserver
* Create an [API-Token](https://dns.hetzner.com/settings/api-token) (Note it down!)
* Create an A and/or AAAA entry in your domain/zone via the [DNS panel](https://dns.hetzner.com/) (Sure, I could have created a script for this as well, but you should check what you are doing, and you get direct feedback, if you do something wrong.)
# Setup
1. Open the setup/start.php in the browser
2. Type in your API token
3. Choose the domain/zone in which your DNS entries/records are in
4. Choose the two entries/records (IPv4 and IPv6) to update (you can also omit one of these, e.g. if you do not have a IPv4 or IPv6)
5. You're done! The final page shows you an example of the update for a FritzBox router (you might have to alter it for your DynDNS client)
6. Recommendation: use https and password protect the directories on you webserver (you never know)
# Limitations
* The script does only minor checks on validity, so use it at own's risk (I am not responsible for any issues caused by it).
* I am not a professional programmer. Code might be ugly or strange to some extent, but it works (at least for me).
* I cannot make wonders happen. E.g. my Synology NAS is not able to transfer the IPv6. Complaints need to go to Synology in this case.
* If you work with IPv6, make sure you understand the difference between IPv4 (NAT concept) vs. IPv6 (direct address), so running a web server behind the router has the same IPv4 but a different IPv6 address.
# Trivia
* This tool was developed on an Android mobile phone with [QuickEdit+](https://play.google.com/store/apps/details?id=com.rhmsoft.edit). Due to my twins I have only rare situations, where I could work on the code and no PC at hand. So, took some weeks to develop. But the kids are cool!! ??

