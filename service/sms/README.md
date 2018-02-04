# SMS Notification Service

This service scan for new image files and when one is found, sends an SMS alert.
The SMS service used is the one provided for free to all [free.fr](http://www.free.fr) customers.

- endpoint : `http://hostname/cam-browser/service/sms`

To be enabled , the SMS Service endpoint should be invoked periodically to test if new images is available.

# URL shortener API

This services uses Google URL API to produce a short url that will be included in the alert SMS sent.
This API requires a **google-apikey**.
