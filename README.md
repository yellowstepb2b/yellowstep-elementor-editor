# Yellowstep Elementor Editor

Semantic Elementor editing helper for Yellowstep/WPVibe development workflows.

## Current version

2.0.0

## What it does

This plugin adds authenticated REST endpoints for inspecting and safely editing Elementor pages.

It creates a semantic map of page structures such as hero heading, hero intro, framework cards, FAQ question/answer pairs, forms, headings and text blocks.

## REST namespace

`/wp-json/yellowstep-editor/v2/`

## Main endpoints

- `GET /pages`
- `GET /templates`
- `GET /structure/{id}`
- `GET /semantic-map/{id}`
- `GET /snapshots/{id}`
- `POST /duplicate-page`
- `POST /create-service-page`
- `POST /update-section-field`
- `POST /update-card`
- `POST /update-faq`
- `POST /replace-text`
- `POST /update-yoast`
- `POST /rollback`
- `POST /regenerate-css`

## Safety

Before every Elementor data write, the current `_elementor_data` is saved to `_yellowstep_editor_snapshot`.

## GitHub notes

Store the source files in GitHub, not only the ZIP. Use releases for downloadable ZIP versions.
