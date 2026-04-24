Design Notes
============

Principles
----------

- Keep helpers small and explicit.
- Avoid framework lock-in.
- Prefer specific namespaces over giant utility buckets.
- Avoid calling something a polyfill unless it behaves like a real polyfill.

Design goals behind the package
-------------------------------

This package is not trying to become a framework for enum metadata. Its design
leans toward a smaller, more reusable middle layer:

- traits for the most common ergonomic gaps in PHP enums
- one static helper surface for external access
- a curated set of packaged enums only where cross-project semantics are stable

Why the package is split by namespace
-------------------------------------

``Calendar`` and ``Sort`` are intentionally separate from ``Common`` because they represent coherent domains with room to grow.

The same logic applies to namespaces such as ``Logger``, ``Runtime``, ``DateTime``, ``Comparison``, and ``Outcome``.

What the package avoids on purpose
----------------------------------

- framework-specific adapters in the runtime API
- reflection-heavy attribute systems
- fake polyfills that do not really mirror native behavior
- giant "everything enum" buckets that hide meaning instead of clarifying it
