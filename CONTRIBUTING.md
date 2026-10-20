# Contributing

Add one unique `.changelog/*.md` fragment for each observable change. With
PHP 8.5+ and CPX, inspect `help add`, then create and validate the note:

```sh
cpx --skip-local fast-forward/changelog add "Describe the observable change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog check --no-interaction
```

After committing, validate the contribution with `check --since=origin/main`.
After `composer install`, read `.agents/skills/fast-forward-changelog/SKILL.md`
for the full procedure. Preserve published history and pending notes; do not add
an `Unreleased` section to `CHANGELOG.md`.

The GitHub workflow checks contributions, maintains PR feedback and prepares a
version PR. Review its exact changes before merging: that approved merge enables
automatic tag and GitHub Release publication. Installing the workflow publishes
nothing.

The development-only `llm/skills` Composer plugin restores the Changelog skill
from the reviewed GitHub source in `skills.json`; generated files are ignored by
Git. Use `composer skills:show` to inspect it and
`composer skills:update --from=github` for an explicit refresh within the
configured version range. Review `skills.json` before changing that range.

This repository selects the published `v0` workflow channel. Release PRs use
`chore(release): fast-forward/enum v{current_version} → v{next_version}` so the
package and version transition are visible before review.
