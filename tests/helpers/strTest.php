<?php

class strTest extends Testcase
{
    public function testStudlyCase()
    {
        $s = studly('string_com-tracos');
        $this->assertEquals($s, 'StringComTracos');
    }
    
    public function testStrToCamelCase()
    {
        $s = camel('string_com-tracos');
        $this->assertEquals($s, 'stringComTracos');
    }
    
    public function testStrContains()
    {
        $s = contains('string/com/qualquer', 'qualquer');
        $this->assertTrue($s);
        $s2 = contains('string/com/qualquer', '/c');
        $this->assertTrue($s2);
    }
    
    public function testStrDoNotContains()
    {
        $s = contains('string/com/qualquer', 'uma');
        $this->assertFalse($s);
    }
    
    public function testStrEndsWith()
    {
        $s = ends_with('string/com/qualquer', 'quer');
        $this->assertTrue($s);
    }
    
    public function testStrDoNotEndsWith()
    {
        $s = ends_with('string/com/qualquer', 'querum');
        $this->assertFalse($s);
    }
    
    public function testStrFinishWithAValue()
    {
        $s = finish('string/com/qualquer', '/');
        $this->assertEquals($s, 'string/com/qualquer/');
        $s2 = finish('string/com/qualquer/', '/');
        $this->assertEquals($s2, 'string/com/qualquer/');
        $s3 = finish('string/com/qualquer//', '/');
        $this->assertEquals($s3, 'string/com/qualquer/');
    }
    
    public function testStrLength()
    {
        $s = length('abcd*=efgh');
        $this->assertEquals($s, 10);
    }
    
    public function testStrLimit()
    {
        $s = limit('abcd*=efgh', 5, '?');
        $this->assertEquals($s, 'abcd*?');
    }
    
    public function testStrToLower()
    {
        $s = lower('GhI$EpM');
        $this->assertEquals($s, 'ghi$epm');
    }
    
    public function testStrLimitWords()
    {
        $s = words('abc def ghi jlk mno', 3, '...');
        $this->assertEquals($s, 'abc def ghi...');
    }
    
    public function testQuickRandom()
    {
        $s = quick_random(13);
        $this->assertEquals(strlen($s), 13);
    }
    
    public function testStrToUpperCase()
    {
        $s = upper('abc def ghi');
        $this->assertEquals($s, 'ABC DEF GHI');
    }
    
//    public function testStrSlug()
//    {
//        $s = slug('abc ** def Çãê');
//        $this->assertEquals($s, 'abc-def-cae');
//    }
    public function testStrToSnakeCase()
    {
        $s = snake('MinhaStringCamelCase', '_');
        $this->assertEquals($s, 'minha_string_camel_case');
    }
    
    public function testStrStartsWith()
    {
        $s = starts_with('/uma/uri/qualquer', '/uma');
        $this->assertTrue($s);
        $s = starts_with('/uma/uri/qualquer', 'uma');
        $this->assertFalse($s);
    }
}