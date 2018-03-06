<?php

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
