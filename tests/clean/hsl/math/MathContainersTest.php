<?hh // strict
/*
 *  Copyright (c) 2004-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the MIT license found in the
 *  LICENSE file in the root directory of this source tree.
 *
 */

use namespace HH\Lib\Math;
use function Facebook\FBExpect\expect;
use type Facebook\HackTest\HackTestCase;

/**
 * @emails oncall+hack
 */
final class MathContainersTest extends HackTestCase {

  public static function provideTestMax(): vec<mixed> {
    return vec[
      tuple(
        vec[],
        null,
      ),
      tuple(
        Set {8, 6, 7, 5, 3, 0, 9},
        9,
      ),
      tuple(
        HackLibTestTraversables::getIterator(
          vec[8, 6, 7, 5, 3, 0, 9],
        ),
        9,
      ),
    ];
  }

  /** @dataProvider provideTestMax */
  public function testMax<T as num>(
    Traversable<T> $numbers,
    ?T $expected,
  ): void {
    expect(Math\max($numbers))->toBeSame($expected);
  }

  public static function provideTestMaxBy(): vec<mixed> {
    return vec[
      tuple(
        vec[],
        $x ==> $x,
        null,
      ),
      tuple(
        vec['the', 'quick', 'brown', 'fox'],
        fun('strlen'),
        'brown',
      ),
      tuple(
        HackLibTestTraversables::getIterator(
          vec['the', 'quick', 'brown', 'fox'],
        ),
        fun('strlen'),
        'brown',
      ),
    ];
  }

  /** @dataProvider provideTestMaxBy */
  public function testMaxBy<T>(
    Traversable<T> $traversable,
    (function(T): num) $num_func,
    ?T $expected,
  ): void {
    expect(Math\max_by($traversable, $num_func))->toBeSame($expected);
  }

  public static function provideTestMean(): vec<mixed> {
    return vec[
      tuple(vec[1.0, 2.0, 3, 4], 2.5),
      tuple(vec[1, 1, 2], 4 / 3),
      tuple(vec[-1, 1], 0.0),
      tuple(vec[], null),
    ];
  }

  /** @dataProvider provideTestMean */
  public function testMean(
    Container<num> $numbers,
    ?float $expected
  ): void {
    $actual = Math\mean($numbers);
    if ($expected === null) {
      expect($actual)->toBeSame(null);
    } else {
      expect($actual)->toAlmostEqual($expected);
    }
  }

  public static function provideTestMedian(): vec<mixed> {
    return vec[
      tuple(vec[], null),
      tuple(vec[1], 1.0),
      tuple(vec[1, 2], 1.5),
      tuple(vec[1, 2, 3], 2.0),
      tuple(vec[9, -1], 4.0),
      tuple(vec[200, -500, 3], 3.0),
      tuple(vec[0, 1, 0, 0], 0.0),
    ];
  }

  /** @dataProvider provideTestMedian */
  public function testMedian(
    Container<num> $numbers,
    ?float $expected,
  ): void {
    if ($expected === null) {
      expect(Math\median($numbers))->toBeSame(null);
    } else {
      expect(Math\median($numbers))->toBeSame($expected);
    }
  }

  public static function provideTestMin(): vec<mixed> {
    return vec[
      tuple(
        vec[],
        null,
      ),
      tuple(
        Set {8, 6, 7, 5, 3, 0, 9},
        0,
      ),
      tuple(
        HackLibTestTraversables::getIterator(
          vec[8, 6, 7, 5, 3, 0, 9],
        ),
        0,
      ),
      tuple(
        Vector {8, 6, 7, -5, -3, 0, 9},
        -5,
      ),
    ];
  }

  /** @dataProvider provideTestMin */
  public function testMin<T as num>(
    Traversable<T> $traversable,
    ?T $expected,
  ): void {
    expect(Math\min($traversable))->toBeSame($expected);
  }

  public static function provideTestMinBy(): vec<mixed> {
    return vec[
      tuple(
        vec[],
        $x ==> $x,
        null,
      ),
      tuple(
        vec['the', 'quick', 'brown', 'fox'],
        fun('strlen'),
        'fox',
      ),
      tuple(
        HackLibTestTraversables::getIterator(
          vec['the', 'quick', 'brown', 'fox'],
        ),
        fun('strlen'),
        'fox',
      ),
    ];
  }

  /** @dataProvider provideTestMinBy */
  public function testMinBy<T>(
    Traversable<T> $traversable,
    (function(T): num) $num_func,
    ?T $expected,
  ): void {
    expect(Math\min_by($traversable, $num_func))->toBeSame($expected);
  }

  public static function provideTestSum(): vec<mixed> {
    return vec[
      tuple(
        Vector {},
        0,
      ),
      tuple(
        vec[1, 2, 1, 1, 3],
        8,
      ),
      tuple(
        HackLibTestTraversables::getIterator(range(1, 4)),
        10,
      ),
    ];
  }

  /** @dataProvider provideTestSum */
  public function testSum(
    Traversable<int> $traversable,
    int $expected,
  ): void {
    expect(Math\sum($traversable))->toBeSame($expected);
  }

  public static function provideTestSumFloat(): vec<mixed> {
    return vec[
      tuple(
        Vector {},
        0.0,
      ),
      tuple(
        vec[1, 2.5, 1, 1, 3],
        8.5,
      ),
      tuple(
        HackLibTestTraversables::getIterator(range(1, 4)),
        10.0,
      ),
    ];
  }

  /** @dataProvider provideTestSumFloat */
  public function testSumFloat<T as num>(
    Traversable<T> $traversable,
    float $expected,
  ): void {
    expect(Math\sum_float($traversable))->toBeSame($expected);
  }
}
