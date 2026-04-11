---
name: generate-changelog
description: Generates a changelog entry for a required target version tag by collecting reverse-ordered commits between a previous tag and HEAD, formatting them as bullet points, and inserting into a changelog file following Keep a Changelog format.
---

# Generate Changelog from Git Log

## Purpose

This skill automates the creation of changelog entries for semantic version releases. It retrieves commits between a previous version tag and HEAD in reverse chronological order, formats them as descriptive bullet points, and inserts a properly formatted section into a changelog file.

## Usage

To use this skill:

1. Provide the required target version tag (new release tag to be written in the changelog)
2. Ensure the repository has git tags following semantic versioning
3. Commit all changes that should appear in the new version
4. Request a changelog entry for the provided target version tag

The skill will:
- Find the most recent tag in the repository
- Retrieve all commits between that tag and HEAD using `git log --reverse`
- Format commits into a markdown changelog section
- Insert the new section at the top of CHANGELOG.md with proper date and GitHub compare link
- Stop and ask for the version tag if it is not provided
- Do not require the target version tag to already exist in git

## Workflow

```bash
# Required input
NEW_TAG="<target-version-tag>"

# Guard: fail if version tag is missing
test -n "$NEW_TAG"

# Get the most recent tag
git describe --tags --abbrev=0

# Get reverse-ordered commits between previous tag and HEAD
git log --reverse --pretty=format:'%s%n' <previous-tag>..HEAD

# Get today's date
date '+%Y-%m-%d'
```

## Output Format

The skill produces a section like:

```markdown
## [<target-version-tag>](https://github.com/OWNER/REPO/compare/<previous-tag>...<target-version-tag>) - YYYY-MM-DD

- First commit subject in range
- Second commit subject in range
- Third commit subject in range
```

## Tips

- Commits are displayed in reverse order (oldest first) as specified by the `--reverse` flag
- Commit messages are used as-is and become bullet points in the changelog
- The GitHub compare link uses the format: `compare/PREVIOUS_TAG...NEW_TAG`
- The new section is always inserted right after the formatting header and before the previous version
- Works best with repositories using semantic versioning and consistent tagging
- Follows Keep a Changelog format (https://keepachangelog.com/en/1.0.0/)

## Prerequisites

- Required target version tag provided by the user (it may be unreleased and not yet present as a git tag)
- Git repository with proper semantic version tags
- CHANGELOG.md file following Keep a Changelog format
- Repository information (owner/repo name) available in attachment or context
