API Reference
=============

This section summarizes the main public surfaces in the package.

Public API map
--------------

.. list-table::
   :header-rows: 1

   * - Surface
     - Purpose
     - Start here when
   * - ``Helper\\EnumHelper``
     - Static operations over enums
     - You want method-by-method helper behavior
   * - Traits
     - Opt-in behavior for enums you own
     - You want methods directly on the enum
   * - Interfaces
     - Small public contracts for labels, descriptions, and reversibility
     - You need to standardize enum behavior across your own codebase
   * - Packaged enums
     - Reusable catalogs by domain
     - You want to know which ready-made enums already exist

.. toctree::
   :maxdepth: 1

   helper
   traits
   contracts
   packaged-enums
