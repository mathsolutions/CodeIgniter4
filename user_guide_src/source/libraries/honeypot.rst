##############
Honeypot Class
##############

The Honeypot Class makes it possible to determine when a Bot makes a request to a CodeIgniter4 application,
if it's enabled in **app/Config/Filters.php** file. This is done by attaching form fields to any form,
and this form field is hidden from a human but accessible to a Bot. When data is entered into the field, it's
assumed the request is coming from a Bot, and you can throw a ``HoneypotException``.

.. contents::
    :local:
    :depth: 2

*****************
Enabling Honeypot
*****************

To enable a Honeypot, changes have to be made to the **app/Config/Filters.php**. Just uncomment honeypot
from the ``$globals`` array, like:

.. literalinclude:: honeypot/001.php

A sample Honeypot filter is bundled, as **system/Filters/Honeypot.php**.
If it is not suitable, make your own at **app/Filters/Honeypot.php**,
and modify the ``$aliases`` in **app/Config/Filters.php** appropriately.

********************
Customizing Honeypot
********************

Honeypot can be customized. The fields below can be set either in
**app/Config/Honeypot.php** or in **.env**.

* ``$hidden`` - ``true`` or ``false`` to control visibility of the honeypot field; default is ``true``
* ``$label`` - HTML label for the honeypot field, default is ``'Fill This Field'``
* ``$name`` - name of the HTML form field used for the template; default is ``'honeypot'``
* ``$template`` - form field template used for the honeypot; default is ``'<label>{label}</label><input type="text" name="{name}" value="">'``
* ``$container`` - container tag for the template; default is ``'<div style="display:none">{template}</div>'``.
  If you enables CSP, you can remove ``style="display:none"``.
* ``$containerId`` - [Since v4.3.0] this setting is used only when you enable CSP. You can change the id attribute for the container tag; default is ``'hpc'``
