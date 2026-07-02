# Yellowstep Elementor Editor

Semantic Elementor editing helper for Yellowstep/WPVibe development workflows.

## Current version

3.0.0

## What it does

This plugin adds:

- REST endpoints under `/wp-json/yellowstep-editor/v3/`
- WordPress Abilities, where supported, under names such as `yellowstep/list-pages`, `yellowstep/duplicate-page`, `yellowstep/update-hero`, `yellowstep/update-card` and `yellowstep/update-faq`

## Main abilities

- `yellowstep/list-pages`
- `yellowstep/list-templates`
- `yellowstep/get-semantic-map`
- `yellowstep/duplicate-page`
- `yellowstep/create-service-page`
- `yellowstep/update-hero`
- `yellowstep/update-card`
- `yellowstep/update-faq`
- `yellowstep/replace-text`
- `yellowstep/update-yoast`
- `yellowstep/list-snapshots`
- `yellowstep/rollback`
- `yellowstep/regenerate-css`

## Safety

Before every Elementor data write, the current `_elementor_data` is saved to `_yellowstep_editor_snapshot`.
