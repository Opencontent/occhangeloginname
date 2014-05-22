<?php

class ChangeLoginName
{
    static public function findLoginName( eZContentObject $object )
    {
        $userAttribute = self::findUserAttribute( $object );
        if ( $userAttribute instanceof eZContentObjectAttribute )
        {
            return $userAttribute->attribute( 'content' )->attribute( 'login' );
        }
        return false;
    }

    static public function findUserAttribute( eZContentObject $object )
    {
        $userAttribute = false;
        $dataMap = $object->attribute( 'data_map' );
        foreach( $dataMap as $attribute )
        {
            if ( $attribute instanceof eZContentObjectAttribute
                && $attribute->attribute( 'data_type_string' ) == 'ezuser' )
            {
                $userAttribute = $attribute;
                break;
            }
        }
        if ( $userAttribute instanceof eZContentObjectAttribute )
        {
            return $userAttribute;
        }
        return false;
    }

    static public function run( $string, eZContentObject $object )
    {
        $userAttribute = self::findUserAttribute( $object );

        if ( !$userAttribute instanceof eZContentObjectAttribute )
        {
            throw new Exception( "Non trovo attributi di tipo ezuser nell'oggetto selezionato" );
        }

        if ( empty( $string ) )
        {
            throw new Exception( "Il nuovo nome non può essere vuoto" );
        }

        $errorText = '';
        if ( !eZUser::validateLoginName( $string, $errorText ) )
        {
            throw new Exception( $errorText );
        }

        if ( eZUser::fetchByName( $string ) )
        {
            throw new Exception( "Il nome \"$string\" è già in uso" );
        }

        $user = $userAttribute->attribute( 'content' );
        $user->setAttribute( "login", $string );
        $user->store();

        return true;
    }

}