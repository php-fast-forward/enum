Installation
============

``fast-forward/enum`` has a very small runtime footprint. The package depends on
PHP's native enum support and does not require a framework bridge, container
integration, or extra runtime libraries.

Requirements
------------

- PHP ``^8.3``
- Composer

Install the package with:

.. code-block:: bash

   composer require fast-forward/enum

What you get after installation
-------------------------------

Once installed, the package exposes three main layers:

- traits under ``FastForward\\Enum\\Trait`` for enums you control
- ``FastForward\\Enum\\Helper\\EnumHelper`` for static operations over existing enums
- packaged enum catalogs under namespaces such as ``Calendar``, ``Sort``, and ``Runtime``

That separation is intentional. New users often expect one of these layers to replace the others,
but in practice they solve different problems.

Development dependencies
------------------------

This repository uses ``fast-forward/dev-tools`` during development. In the package repository itself, the most reliable validation commands are:

.. code-block:: bash

   composer dump-autoload
   ./vendor/bin/dev-tools tests

Namespace layout
----------------

The package is intentionally grouped by concern:

- ``FastForward\\Enum\\Trait`` for reusable enum traits
- ``FastForward\\Enum\\Helper`` for static helpers
- domain namespaces such as ``Calendar``, ``Sort``, ``Logger``, ``Runtime``, ``DateTime``, ``Comparison``, ``Outcome``, ``Http``, ``Process``, ``Event``, ``Container``, and ``Pipeline``

Choosing the right API surface
------------------------------

Use traits when:

- you own the enum declaration
- you want methods such as ``values()`` or ``fromName()`` directly on the enum
- you want the enum itself to advertise those behaviors

Use ``EnumHelper`` when:

- the enum is defined in another package
- you do not want to mix traits into the enum declaration
- you need one-off utility access from presenters, validators, serializers, or forms

Use packaged enums when:

- the semantics are already stable and reusable across projects
- names like ``Environment`` or ``SortDirection`` really match the problem you have

If the semantics are business-specific, prefer defining your own enum and layering Fast Forward
traits on top of it.
