# Changelog

All notable changes to this project are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project
adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased] - 2026-10-21

### Added

- Social Media Links (`social`): a profile for each of Facebook, Instagram, LinkedIn, X, YouTube, TikTok, Pinterest,
  Threads, Bluesky, Mastodon, Vimeo and Behance, under the keys the CMS's Social Media Links plugin used
  (`social.social_*`).
- A field type for each network (`social:facebook` … `social:behance`), which accepts the profile's address or just the
  account, stores it as the editor gave it, and refuses anything that isn't a profile on its network. Values the plugin
  stored are never rewritten, so templates that build links from them keep working.
- Share Buttons (`social-share`): which buttons, in what order, names beside icons, and UTM tags
  (`extensions.social.*`).

### Changed

- Requires the library under its new name, `contenir/contenir-social` `^0.1` (it was `contenir/social`), from its
  repository until it is listed on Packagist.
