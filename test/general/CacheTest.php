<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

class CacheTest extends BaseTest {
  public function testSet() {
    $cache = new Google_FileCache();
    $cache->set('foo', 'bar');
    $this->assertEquals($cache->get('foo'), 'bar');

    $cache->set('foo.1', 'bar.1');
    $this->assertEquals($cache->get('foo.1'), 'bar.1');

    $cache->set('foo', 'baz');
    $this->assertEquals($cache->get('foo'), 'baz');

    $cache->set('foo', null);
    $this->assertEquals($cache->get('foo'), null);

    $cache->set('1/2/3', 'bar');
    $this->assertEquals($cache->get('1/2/3'), 'bar');

    $obj = new stdClass();
    $obj->foo = 'bar';
    $cache->set('foo', $obj);
    $this->assertEquals($cache->get('foo'), $obj);
  }

  public function testDelete() {
    global $apiConfig;
    $apiConfig['ioFileCache_directory'] = '/tmp/google-api-php-client/tests';
    $cache = new Google_FileCache();
    $cache->set('foo', 'bar');
    $cache->delete('foo');
    $this->assertEquals($cache->get('foo'), false);

    $cache->set('foo.1', 'bar.1');
    $cache->delete('foo.1');
    $this->assertEquals($cache->get('foo.1'), false);

    $cache->set('foo', 'baz');
    $cache->delete('foo');
    $this->assertEquals($cache->get('foo'), false);

    $cache->set('foo', null);
    $cache->delete('foo');
    $this->assertEquals($cache->get('foo'), false);

    $obj = new stdClass();
    $obj->foo = 'bar';
    $cache->set('foo', $obj);
    $cache->delete('foo');
    $this->assertEquals($cache->get('foo'), false);
  }
}