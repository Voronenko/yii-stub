<?php

interface IIOC {
   function RegisterInstance($Type, $name, $instance, $lifetimemanager);
   function RegisterType($Type,$CreatorClass,$lifetimemanager);
   function Resolve($Type, $name, $ResolverOverride);
}
