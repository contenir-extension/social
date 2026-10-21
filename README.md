# contenir-extension/social

[![Continuous Integration](https://github.com/contenir-extension/social/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/contenir-extension/social/actions/workflows/continuous-integration.yml)

The Social add-on for Contenir CMS: the site's profiles on twelve networks, each checked as it is saved, and the share
buttons on its pages, chosen and ordered by editors. It replaces the CMS's Social Media Links plugin, with the same
settings keys, and the empty Share plugin.

It is built like [the Tracking add-on](https://github.com/contenir-extension/tracking), the reference add-on, whose
README describes how every add-on is laid out, built, tested and released.

## What it adds

**Social Media Links**, under Site Settings > Social, where the CMS's plugin of that name was:

| Field | Stored under | Field type |
|---|---|---|
| Facebook page | `social.social_facebook` | `social:facebook` |
| Instagram | `social.social_instagram` | `social:instagram` |
| LinkedIn page | `social.social_linkedin` | `social:linkedin` |
| X (Twitter) | `social.social_twitter` | `social:x` |
| YouTube channel | `social.social_youtube` | `social:youtube` |
| TikTok | `social.social_tiktok` | `social:tiktok` |
| Pinterest | `social.social_pinterest` | `social:pinterest` |
| Threads | `social.social_threads` | `social:threads` |
| Bluesky | `social.social_bluesky` | `social:bluesky` |
| Mastodon | `social.social_mastodon` | `social:mastodon` |
| Vimeo | `social.social_vimeo` | `social:vimeo` |
| Behance | `social.social_behance` | `social:behance` |

The first five keep the plugin's keys, and the new networks join them under `social`, so anything reading profiles
finds them in one place: sites, and the SEO add-on for schema.org's `sameAs`. Neither add-on depends on the other.

Each field type accepts the profile's address in any form the network serves it in, or just the account
(`@yourname`, `yourname.bsky.social`, `@yourname@server`; LinkedIn needs the address), and stores it as the editor gave
it. Anything else is refused with a message saying why ("That address is on www.instagram.com, not Facebook…").

Stored values are never rewritten. The plugin stored Instagram, X and Pinterest as usernames, and templates that build
a link from a stored username (`https://instagram.com/<username>`) keep working. contenir/social builds the full
address from either form when a page is written: `socialProfiles()` for the links, and the X account for
`twitter:site`. Sites move to the helper when it suits them (Simon's choice, replacing SOC-2's convert-on-save).

**Share Buttons**, also under Social:

| Field | Stored under | Default |
|---|---|---|
| Buttons: rows, each a button, dragged into order | `extensions.social.share_networks` | none chosen: Facebook, X, LinkedIn, Email, Copy link, Share… |
| Show names beside icons | `extensions.social.share_labels` | on |
| Add UTM tags | `extensions.social.share_utm` | off |

The buttons are Facebook, X, LinkedIn, WhatsApp, Email, Bluesky, Threads, Reddit, Pinterest (on pages with an image),
Telegram, Copy link and Share… (only where the browser has a share sheet, SOC-3). Each is a plain link built from the
page's own metadata: no third-party scripts, counts or cookies, so nothing reaches a network until a visitor clicks.

Sites print both with a site adapter. On Laminas MVC that is
[contenir/social-laminas-mvc](https://github.com/contenir/contenir-social-laminas-mvc)'s `socialProfiles()` and
`share()`. [contenir/social](https://github.com/contenir/contenir-social) does the work: the networks, the checks,
the share addresses, the HTML, the icons and the script.

It has no checks, listeners, handlers, scripts or tables. It stores no personal data: only the site's own profile
addresses.

## Requirements

- PHP 8.3, 8.4 or 8.5
- A CMS that hosts contenir/extension-api 0.5

## Installing

```bash
composer require contenir-extension/social
```

Then enable it in the site's `config/autoload/extensions.global.php`:

```php
return ['extensions' => ['enabled' => ['social']]];
```

---

## For later add-ons

What this add-on found that the Tracking add-on's guide doesn't yet say:

- **Two sections.** An add-on's sections are named after its handle: `social`, then `social-share`. A built-in
  section that moves into an add-on under a new name (here `sociallink` became `social`) keeps its keys through
  `setting:`, but its permission grants name the old section, so the CMS's cut-over copies them.
- **Normalise, then validate.** The CMS runs a field type's `normalise()` before `validate()`. A field type that tidies
  values should return what it was given when it can't tidy it, so `validate()` sees the editor's value and can say
  what is wrong with it.
- **A text control for values that aren't addresses.** The profile fields are text, not URL, controls, so a handle
  shows as it is and the browser doesn't refuse to submit it.
- **Keep what editors type.** Rewriting a stored value on save would break any template that reads it as it was; a
  field type that accepts several forms should store the one given and leave the library to read them all.
- **Repeating rows have no default.** A multilink field can't declare default rows, so an empty list means the
  library's default buttons; a site that wants none leaves `share()` out of its templates.
- **Scripts only where they're needed.** The script behind "Copy link" and "Share…" is written by the site adapter,
  next to the buttons, rather than offered through the script contract for every page.

## Licence

BSD-3-Clause. See [LICENSE.md](LICENSE.md).
