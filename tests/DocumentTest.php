<?php
/**
 * Ember Db - An embeddable document database for php.
 * Copyright (C) 2016 Alexander During
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://github.com/alexanderduring/php-ember-db
 * @copyright Copyright (C) 2016 Alexander During
 * @license   http://www.gnu.org/licenses GNU General Public License v3.0
 */

namespace EmberDb;

use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function providerHas()
    {
        $defaultPreconditions = [
            'document' => [
                'foo' => [
                    'bar' => 'baz'
                ]
            ]
        ];
        $defaultExpectations = [];

        $testCases = [
            '1-element subpath of existing 2-element-path' => [
                'preconditions' => [
                    'path' => 'foo'
                ],
                'expectations' => [
                    'has' => true
                ]
            ],
            'Existing, two-element path' => [
                'preconditions' => [
                    'path' => 'foo.bar'
                ],
                'expectations' => [
                    'has' => true
                ]
            ],
            'Non-existing, two-element path' => [
                'preconditions' => [
                    'path' => 'foo.baz'
                ],
                'expectations' => [
                    'has' => false
                ]
            ],
            'Non-existing 3-element-path in a document only containing 2-element-paths' => [
                'preconditions' => [
                    'path' => 'foo.bar.baz'
                ],
                'expectations' => [
                    'has' => false
                ]
            ],
            'Non-existing 3-element-path in a document only containing 2-element-paths with an empty array' => [
                'preconditions' => [
                    'document' => [
                        'foo' => [
                            'bar' => []
                        ]
                    ],
                    'path' => 'foo.bar.baz'
                ],
                'expectations' => [
                    'has' => false
                ]
            ],
        ];

        // Merge test data with default data
        foreach ($testCases as &$testCase) {
            $testCase['preconditions'] = array_merge($defaultPreconditions, $testCase['preconditions']);
            $testCase['expectations'] = array_merge($defaultExpectations, $testCase['expectations']);
        }

        return $testCases;
    }


    /**
     * @dataProvider providerHas
     */
    public function testHas($preconditions, $expectations)
    {
        $document = new Document($preconditions['document']);
        $has = $document->has($preconditions['path']);

        $this->assertEquals($expectations['has'], $has);
    }
}
