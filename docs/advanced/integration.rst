Integration
===========

This package is framework-agnostic, so integration is usually just normal PHP usage.

Typical integration points
--------------------------

- DTO validation and serialization
- form/select option generation
- API filtering with ``ComparisonOperator``
- logging decisions with ``LogLevel``
- runtime configuration with ``Environment``
- custom sort implementations using ``SortDirection`` and ``ComparisonResult``
- date/time calculations with ``Month``, ``Quarter``, and ``IntervalUnit``

Typical application patterns
----------------------------

Common integration patterns include:

- building form option lists from ``options()`` or ``EnumHelper::options()``
- validating case names coming from user input with ``fromName()`` or ``hasName()``
- converting backed values from storage or APIs into cases
- sharing stable enums such as ``Environment`` or ``LogLevel`` across multiple packages

Container usage
---------------

No service provider is required. Import the enum or helper directly where needed.

Framework usage
---------------

In frameworks, this usually means:

- enums live in your domain or shared library namespace
- traits are added to enums you own
- ``EnumHelper`` is used in UI adapters, serializers, controllers, and validators

There is no special registration step.

Troubleshooting
---------------

- If a helper expects a backed enum, prefer ``EnumHelper`` methods that are documented for ``BackedEnum`` rather than plain ``UnitEnum``.
- If you need business-specific labels or transitions, create your own enum instead of forcing packaged catalogs to fit.
- When reorganizing enums across namespaces in your own project, run ``composer dump-autoload`` before debugging missing classes.
- If names and values are getting mixed up in external input, document clearly whether your boundary accepts case names or backed values.
