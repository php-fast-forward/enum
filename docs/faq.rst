FAQ
===

This FAQ focuses on the questions new users usually hit after the first install:
which API to choose, how to avoid overusing packaged enums, and how the helper
methods relate to native enum behavior.

Why are interfaces not in ``Contracts``?
----------------------------------------

The package keeps public interfaces in the root namespace to avoid deep namespace chains for a very small API.

Is this package framework-specific?
-----------------------------------

No. It is intentionally framework-agnostic.

Should I use the packaged enums everywhere?
-------------------------------------------

No. Use them when the semantics are truly generic. Keep domain-specific enums in your own package.

Why both traits and ``EnumHelper``?
----------------------------------

Traits are useful when you own the enum declaration. ``EnumHelper`` is useful when you want the behavior externally or prefer not to mix traits into the enum.

Does ``StateMachine\\HasTransitions`` replace a workflow engine?
---------------------------------------------------------------

No. It is a lightweight helper for explicit transitions inside enum-based workflows.

Is ``ComparisonResult`` a PHP polyfill?
---------------------------------------

No. It is a utility enum for sort/comparison flows, not a real native polyfill.

Can I combine many traits in one enum?
--------------------------------------

Yes, but only combine the traits that actually describe the enum behavior you want to expose.

Where should I start as a new user?
-----------------------------------

Read ``getting-started/installation.rst`` and ``getting-started/quickstart.rst`` first, then move to ``usage/traits.rst`` or ``usage/catalogs.rst`` depending on your use case.

How do I use the package from a container or framework?
-------------------------------------------------------

Usually you do not need special integration. Import the enum or ``EnumHelper`` directly inside your service class and keep the enum itself framework-agnostic.

What should I check if autoloading looks broken after adding a new enum?
------------------------------------------------------------------------

Run ``composer dump-autoload`` and confirm the namespace matches the file path. This is especially important after moving enums between namespaces such as ``Common``, ``Sort``, or ``Calendar``.

How do I decide between packaged enums and application-specific enums?
----------------------------------------------------------------------

Use packaged enums only when the meaning is stable across projects. If the cases, labels, or transitions are tied to your business language, define your own enum and use the traits or helper APIs on top of it.
