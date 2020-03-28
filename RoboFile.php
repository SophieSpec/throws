<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use PHLAK\SemVer;

final class RoboFile extends Robo\Tasks
{
    public function publish(string $version): void
    {
        $new = new SemVer\Version($version);
        $current = new SemVer\Version(`git describe --abbrev=0 --tags` ?? '0.0.0');
        if ($new->gt($current) === false) {
            throw new Exception(
                "Invalid semver: '$new' should be greater than '$current'"
            );
        }
        if ($current->major + 1 !== $new->major
            && $current->minor + 1 !== $new->minor
            && $current->patch + 1 !== $new->patch
        ) {
            throw new Exception(
                "Invalid semver: '$new' should be incremented by 1 compared to '$current'"
            );
        }
        $this->_exec('git checkout master');
        $this->_exec('git pull');
        $this->_exec("git tag $new");
        $this->_exec('git push --tags');
    }
}
