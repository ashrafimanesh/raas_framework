<?php


class create_sample_table{

    public static function up(){
        Schema::create('sample_table', function(SchemaStruct $SchemaStruct){
            $SchemaStruct->integer('id')->autoIncrement()->primaryKey();
            $SchemaStruct->tinyInt('field1');
            $SchemaStruct->bigInt('field2');
            $SchemaStruct->string('field3');
            $SchemaStruct->float('field4')->notNull();
        });
    }

    public static function down(){    
        
        Schema::drop('sample_table');
    
    }

}

