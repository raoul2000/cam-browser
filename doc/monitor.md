# Monitor

## Overview

Because it was not possible to configure the box to use a fixed IP address, I had to
implement this monitor feature. The idea is to let the webcam periodically call
a specific URL in order to provide its current public IP.

```
#!/bin/bash
curl http://you-hostname/san-luis-control/monitor/ping/ > /dev/null 2>&1
```

Another constraint was the poor internet quality : the connection was broken several
minutes (hours ?) per day and so, the **monitor** page will use the call made by
the webcam to displays a live status to the user.

## Configuration

The *Monitor* has no specific configuration settings, it's just a HTML page produced by a PHP script that is in charge of injecting the current IP. Add some js and you're ready !
