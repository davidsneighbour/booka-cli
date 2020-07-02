#!/bin/bash

rm -f CHANGELOG.md
{
  echo "# Changelog"
} >>CHANGELOG.md

git tag | sort -t. -k 1,1nr -k 2,2nr -k 3,3nr -k 4,4nr | while read -r TAG; do

  if [ "$NEXT" ]; then
    {
      echo
      echo "## $NEXT"
      echo
      GIT_PAGER=$(git log --no-merges --format="- [%h] %s (%cd)" "$TAG".."$NEXT")
      echo "$GIT_PAGER"
    } >>CHANGELOG.md
  else
    PACKAGE_VERSION=$(< package.json grep version \
      | head -1 \
      | awk -F: '{ print $2 }' \
      | sed 's/[",]//g')
    {
      echo
      echo "##$PACKAGE_VERSION"
      echo
      GIT_PAGER=$(git log --no-merges --format="- [%h] %s (%cd)" "$TAG"..HEAD)
      echo "$GIT_PAGER"
    } >>CHANGELOG.md
  fi

  NEXT=$TAG
done
