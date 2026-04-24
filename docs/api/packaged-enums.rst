Packaged Enums
==============

The library includes reusable enum catalogs across several namespaces. This
page is meant to answer two questions:

1. which namespaces already exist?
2. what kind of problem does each namespace target?

Namespace overview
------------------

.. list-table::
   :header-rows: 1

   * - Namespace
     - Focus
     - Examples
   * - ``Calendar``
     - date and period modeling
     - ``Month``, ``Quarter``, ``Semester``, ``Weekday``
   * - ``Sort``
     - ordering semantics
     - ``SortDirection``, ``NullsPosition``, ``CaseSensitivity``, ``ComparisonResult``
   * - ``Logger``
     - logging severity semantics
     - ``LogLevel``
   * - ``Runtime``
     - deployment/runtime distinctions
     - ``Environment``
   * - ``DateTime``
     - interval naming and conversions
     - ``IntervalUnit``
   * - ``Comparison``
     - filter-style operators
     - ``ComparisonOperator``
   * - ``Outcome``
     - success and failure states
     - ``Result``
   * - ``Http``
     - network scheme semantics
     - ``Scheme``
   * - ``Process``
     - process-handling choices
     - ``SignalBehavior``
   * - ``Event``
     - event-dispatch semantics
     - ``DispatchMode``
   * - ``Container``
     - container lifetime concepts
     - ``ServiceLifetime``
   * - ``Pipeline``
     - pipeline failure behavior
     - ``FailureMode``

Selection guidance
------------------

If the enum name already matches your problem and the cases read naturally in
your code, a packaged enum is probably a good fit. If you find yourself wanting
to rename every case, that is a strong signal that your project should define
its own enum instead.

Detailed catalog
----------------

``Calendar\\Month``
^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents Gregorian months as a backed enum with calendar-aware helpers.

Useful methods:
   - ``quarter()``
   - ``isQuarterEnd()``
   - ``ordered()``
   - inherited helpers such as ``values()``, ``options()``, ``nameMap()``, and ``fromName()``

Typical use:
   monthly reporting, fiscal logic, quarter calculations, and typed date-related UI choices.

``Calendar\\Quarter``
^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents four yearly quarters and bridges quarter logic back to months.

Useful methods:
   - ``months()``
   - ``startMonth()``
   - ``endMonth()``
   - ``includes()``
   - ``ordered()``
   - ``fromMonth()``

Typical use:
   dashboards, reporting periods, planning windows, and quarterly grouping logic.

``Calendar\\Semester``
^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents first-half and second-half yearly periods.

Useful methods:
   - ``months()``
   - ``quarters()``
   - ``startMonth()``
   - ``endMonth()``
   - ``includes()``
   - ``fromMonth()``
   - ``fromQuarter()``

Typical use:
   half-year reports, academic terms, release planning, and annual roadmaps.

``Calendar\\Weekday``
^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents ISO-style weekdays with weekend awareness.

Useful methods:
   - ``isWeekend()``
   - ``isWeekday()``
   - ``ordered()``

Typical use:
   scheduling, business-calendar rules, reminders, and delivery constraints.

``Runtime\\Environment``
^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents runtime or deployment environments.

Useful methods:
   - ``isProduction()``
   - ``isPreProduction()``
   - ``isDebugFriendly()``

Typical use:
   config branching, bootstrapping decisions, and operational safeguards.

``Logger\\LogLevel``
^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents reusable log-severity ordering.

Useful methods:
   - ``weight()``
   - ``isAtLeast()``
   - ``ordered()``

Typical use:
   log filtering, alert thresholds, and reusable logger-facing decisions.

``Common\\Priority``
^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents task or work-item priority.

Useful methods:
   - ``weight()``
   - ``isHigherThan()``
   - ``isLowerThan()``
   - ``ordered()``

Typical use:
   queues, workflows, ticket systems, and operational triage.

``Common\\Severity``
^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents severity levels for events or findings.

Useful methods:
   - ``weight()``
   - ``isAtLeast()``
   - ``ordered()``

Typical use:
   observability, diagnostics, incident review, and warnings vs errors.

``DateTime\\IntervalUnit``
^^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents named interval units from seconds to years.

Useful methods:
   - ``shortLabel()``
   - ``seconds()``
   - ``isCalendarAware()``

Typical use:
   TTLs, retries, schedules, reporting windows, and human-readable interval choices.

``Comparison\\ComparisonOperator``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents reusable filter and rule operators.

Useful methods:
   - ``symbol()``
   - ``isSetOperator()``
   - ``compare()``
   - ``negate()``

Typical use:
   query builders, filter UIs, rule engines, and validator abstractions.

``Outcome\\Result``
^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents success, partial success, or failure.

Useful methods:
   - ``isSuccessful()``
   - ``isCompleteSuccess()``
   - ``isFailure()``

Typical use:
   command handlers, jobs, integration results, and workflow outcomes.

``Http\\Scheme``
^^^^^^^^^^^^^^^^

Purpose:
   Represents ``http`` and ``https`` with transport-aware helpers.

Useful methods:
   - ``defaultPort()``
   - ``isSecure()``

Typical use:
   URI handling, client/server configuration, and environment validation.

``Process\\SignalBehavior``
^^^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents how a process should react to signals.

Useful methods:
   - ``isTerminalControl()``

Typical use:
   CLI tooling, worker orchestration, and process-control policies.

``Event\\DispatchMode``
^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents synchronous vs asynchronous dispatch behavior.

Useful methods:
   - ``isSync()``
   - ``isAsync()``

Typical use:
   event dispatchers, buses, and internal delivery decisions.

``Container\\ServiceLifetime``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents reusable vs transient service lifetimes.

Useful methods:
   - ``isReusable()``

Typical use:
   container configuration, service metadata, and lifecycle decisions.

``Pipeline\\FailureMode``
^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents whether a pipeline should stop or continue after failures.

Useful methods:
   - ``stopsOnFailure()``

Typical use:
   middleware chains, processing pipelines, and staged command execution.

``Sort\\SortDirection``
^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents ascending vs descending order without booleans or string flags.

Useful methods:
   - ``reverse()``
   - ``isAscending()``
   - ``isDescending()``
   - ``factor()``
   - ``applyToComparisonResult()``

Typical use:
   query sorting, in-memory ordering, and comparator adaptation.

``Sort\\NullsPosition``
^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents whether null values sort first or last.

Useful methods:
   - ``reverse()``
   - ``isFirst()``
   - ``isLast()``
   - ``compareNullability()``

Typical use:
   database-like sorting rules, report ordering, and nullable field handling.

``Sort\\CaseSensitivity``
^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents whether string comparisons preserve case.

Useful methods:
   - ``reverse()``
   - ``isSensitive()``
   - ``isInsensitive()``
   - ``normalize()``
   - ``equals()``

Typical use:
   search, filters, sort behavior, and user-input comparison.

``Sort\\ComparisonResult``
^^^^^^^^^^^^^^^^^^^^^^^^^^

Purpose:
   Represents comparator-style outcomes as a typed enum instead of raw integers.

Useful methods:
   - ``fromComparisonResult()``
   - ``toComparisonResult()``
   - ``reverse()``
   - ``isComparable()``

Typical use:
   comparator composition, sorting adapters, and comparison-heavy domain logic.
