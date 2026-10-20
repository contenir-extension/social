# Changelog

All notable changes to this project are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project
adheres to [Semantic Versioning](https://semver.org/).

## [Unreleased] - 2026-10-21

### Added

- Social Media Links (`social`): a profile for each of Facebook, Instagram, LinkedIn, X, YouTube, TikTok, Pinterest,
  Threads, Bluesky and Mastodon, under the keys the CMS's Social Media Links plugin used (`social.social_*`).
- A field type for each network (`social:facebook` … `social:mastodon`), which stores the profile's canonical address
  and refuses anything that isn't a profile on its network. Handles saved by the plugin become addresses on the next
  save.
- Share Buttons (`social-share`): which buttons, in what order, names beside icons, and UTM tags
  (`extensions.social.*`).
