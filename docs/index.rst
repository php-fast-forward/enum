Fast Forward Enum
=================

.. container:: row align-items-center gy-4 my-4

   .. container:: col-lg-7

      ``fast-forward/enum`` is a PHP 8.3+ library for enum ergonomics, reusable
      enum catalogs, and small behavioral helpers that stay framework-agnostic.

      The package is designed for developers who want:

      - convenience helpers such as ``values()``, ``names()``, maps, and lookups
      - reusable enum catalogs grouped by domain instead of one giant ``Common`` bucket
      - a clean, typed way to model small behaviors such as reversible sort directions or state-machine transitions
      - documentation and examples that are approachable for first-time users

      If you are new to the package, start with
      :doc:`getting-started/index` and :doc:`usage/index`. They explain the
      difference between traits, ``EnumHelper``, and the packaged enums, which
      is the main conceptual jump for most first-time users.

      If you already know the problem you want to solve, continue with
      :doc:`api/index` and :doc:`advanced/index` for helper method details,
      namespace design, workflow traits, and integration guidance.

   .. container:: col-lg-5 text-center

      .. image:: _static/enum-mascot-banner.png
         :alt: Fast Forward Enum mascot banner
         :class: img-fluid w-100 rounded-4 shadow-sm border border-light-subtle bg-body-tertiary p-2

Useful links
------------

- `Repository <https://github.com/php-fast-forward/enum>`_
- `Packagist <https://packagist.org/packages/fast-forward/enum>`_
- `Coverage <https://php-fast-forward.github.io/enum/coverage/index.html>`_
- `API Reference <api/index.html>`_
- `Issue Tracker <https://github.com/php-fast-forward/enum/issues>`_
- `Project Wiki <https://github.com/php-fast-forward/enum/wiki>`_

.. toctree::
   :maxdepth: 2
   :caption: Contents

   getting-started/index
   usage/index
   api/index
   advanced/index
   links/index
   faq
   compatibility
