<?php

return [
    'heading' => 'Welcome to :app!',
    'version' => 'Version: :version',
    'advanced' => 'Advanced',
    'server' => 'Server',
    'user' => 'User',
    'sections' => [
        'intro-developers' => [
            'heading' => 'Information for Developers',
            'content' => 'Thank you for trying out the development version!',
            'extra_note' => 'If you run into any issues, please report them on GitHub.',
            'button_issues' => 'Create Issue',
            'button_features' => 'Discuss Features',
        ],
        'intro-update-available' => [
            'heading' => 'Update available',
            'content' => ':latestVersion is now available! Read our documentation to update your Panel.',
            'content_container' => ':latestVersion is now available! Pull the new image and recreate the container to update your Panel.',
            'button_changelog' => 'What\'s New?',
        ],
        'intro-version-unavailable' => [
            'heading' => 'Version check unavailable',
            'content' => 'You are currently using :version. The latest version could not be fetched from GitHub, so it is unknown whether an update is available.',
        ],
        'intro-no-update' => [
            'heading' => 'Your Panel is up to date',
            'content' => 'You are currently using :version. Your panel is up-to-date!',
        ],
        'intro-first-node' => [
            'heading' => 'No Nodes Detected',
            'content' => "It looks like you don't have any Nodes set up yet, but don't worry because you click the action button to create your first one!",
            'extra_note' => 'If you run into any issues, please report them on GitHub.',
            'button_label' => 'Create first Node',
        ],
        'intro-support' => [
            'heading' => 'Corex Infrastructure',
            'content' => 'High-performance game server and container orchestration platform with ultra-low latency.',
            'extra_note' => 'Native multi-architecture ARM64 & x86_64 support.',
            'button_translate' => 'Community',
            'button_donate' => 'Documentation',
        ],
        'intro-help' => [
            'heading' => 'Need Help?',
            'content' => 'Check out the documentation first! If you still need help head on over to our discord server!',
            'button_docs' => 'Read Documentation',
        ],
    ],
];
