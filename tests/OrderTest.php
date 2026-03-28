<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../www/Order.php';

class OrderTest extends TestCase
{
    private $pdoMock;
    private $order;
    
    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->order = new Order($this->pdoMock);
    }
    

    public function testAddOrder()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);
        
        $this->pdoMock->expects($this->once())
                      ->method('prepare')
                      ->willReturn($stmtMock);
        
        $result = $this->order->add('Ivan', 'Italian', 3, 1, 'C');
        
        $this->assertTrue($result);
    }
    
   
    public function testGetAllOrders()
    {
        $expected = [['id' => 1, 'username' => 'Ivan']];
        
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('fetchAll')
                 ->willReturn($expected);
        
        $this->pdoMock->expects($this->once())
                      ->method('query')
                      ->willReturn($stmtMock);
        
        $result = $this->order->getAll();
        
        $this->assertCount(1, $result);
        $this->assertEquals('Ivan', $result[0]['username']);
    }
    

    public function testAddOrderWithMock()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with(['Ivan', 'Italian', 3, 1, 'C'])
                 ->willReturn(true);
        
        $this->pdoMock->expects($this->once())
                      ->method('prepare')
                      ->with("INSERT INTO orders (username, restaurant, count_order, type_pay, type_boxing) VALUES (?, ?, ?, ?, ?)")
                      ->willReturn($stmtMock);
        
        $result = $this->order->add('Ivan', 'Italian', 3, 1, 'C');
        
        $this->assertTrue($result);
    }
}