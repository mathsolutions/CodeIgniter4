################
CodeIgniter URLs
################

.. contents::
    :local:
    :depth: 2

By default, URLs in CodeIgniter are designed to be search-engine and human-friendly. Rather than using the standard
"query-string" approach to URLs that is synonymous with dynamic systems, CodeIgniter uses a **segment-based** approach::

    https://example.com/news/article/my_article

Your URLs can be defined using the :doc:`URI Routing </incoming/routing>` feature with flexibility.

The :doc:`URI Library <../libraries/uri>` and the :doc:`URL Helper <../helpers/url_helper>` contain functions that make it easy to work with your URI data.

.. _urls-url-structure:

URL Structure
=============

Base URL contains only the Hostname
-----------------------------------

When you have the Base URL **https://www.example.com/** and imagine the following URL::

    https://www.example.com/blog/news/2022/10?page=2

We use the following terms:

========== ============================ =========================================
Term       Example                      Description
========== ============================ =========================================
Base URL   **https://www.example.com/** Base URL is often denoted as **baseURL**.
URI path   /blog/news/2022/10
Route path /blog/news/2022/10           The URI path relative to the Base URL.
                                        It is also called as **URI string**.
Query      page=2
========== ============================ =========================================

Base URL contains Sub folders
-----------------------------

When you have the Base URL **https://www.example.com/ci-blog/** and imagine the following URL::

    https://www.example.com/ci-blog/blog/news/2022/10?page=2

We use the following terms:

========== ==================================== =========================================
Term       Example                              Description
========== ==================================== =========================================
Base URL   **https://www.example.com/ci-blog/** Base URL is often denoted as **baseURL**.
URI path   /ci-blog/blog/news/2022/10
Route path /blog/news/2022/10                   The URI path relative to the Base URL.
                                                It is also called as **URI string**.
Query      page=2
========== ==================================== =========================================

.. _urls-uri-security:

URI Security
============

.. versionadded:: 4.4.7

.. important::
    Users upgrading from versions prior to v4.4.7 will need to add the following
    to **app/Config/App.php** in order to use this feature::

        public string $permittedURIChars = 'a-z 0-9~%.:_\-';

CodeIgniter is fairly restrictive regarding which characters it allows in your
URI strings (Route path) in order to help minimize the possibility that malicious
data can be passed to your application. URIs may only contain the following:

-  Alpha-numeric text (latin characters only)
-  Tilde: ``~``
-  Percent sign: ``%``
-  Period: ``.``
-  Colon: ``:``
-  Underscore: ``_``
-  Dash: ``-``
-  Space: `` ``

.. note::
    This check is performed by the ``Router``. The Router takes the URL-encoded
    value held by the ``SiteURI`` class, decodes it, and then checks that it
    does not contain not permitted strings.

Adding Permitted Characters
---------------------------

The permitted characters can be changed by ``Config\App::$permittedURIChars``.

If you want to use Unicode for URI paths, modify it to allow the characters to
be used. For example, if you want to use Bengali, you will need to set the
following value in **app/Config/App.php**::

    public string $permittedURIChars = 'a-z 0-9~%.:_\-\x{0980}-\x{09ff}';

A full list of Unicode ranges can be found at Wikipedia's `Unicode block`_.

.. _Unicode block: https://en.wikipedia.org/wiki/Unicode_block

.. _urls-remove-index-php:

Removing the index.php file
===========================

When you use Apache Web Server, by default, the **index.php** file will be needed in your URLs::

    example.com/index.php/news/article/my_article

If your server supports rewriting URLs you can easily remove this file with URL rewriting. This is handled differently
by different servers, but we will show examples for the two most common web servers here.

.. _urls-remove-index-php-apache:

Apache Web Server
-----------------

Apache must have the *mod_rewrite* extension enabled. If it does, you can use a ``.htaccess`` file with some simple rules.
Here is an example of such a file, using the "negative" method in which everything is redirected except the specified
items:

.. code-block:: apache

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]

In this example, any HTTP request other than those for existing directories and existing files are treated as a
request for your index.php file.

.. note:: These specific rules might not work for all server configurations.

.. note:: Make sure to also exclude from the above rules any assets that you might need to be accessible from the outside world.

.. _urls-remove-index-php-nginx:

nginx
-----

Under nginx, you can define a location block and use the ``try_files`` directive to get the same effect as we did with
the above Apache configuration:

.. code-block:: nginx

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

This will first look for a file or directory matching the URI (constructing the full path to each file from the
settings of the root and alias directives), and then sends the request to the index.php file along with any arguments.
