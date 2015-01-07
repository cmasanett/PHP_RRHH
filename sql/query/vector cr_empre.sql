SELECT dato_legajo_baja, comparacion, valor_dato_baja FROM zend_php_demo.n7_empresas WHERE id = 3
--empresa activa (vector cr_empre)
   IF UPPER(ALLTRIM(cr_empre.comparacion)) = "EN"
      vlc_condicion = " in ("+ cr_empre.valor_dato_baja+")"
   ELSE   
      vlc_condicion = cr_empre.comparacion + cr_empre.valor_dato_baja
   END IF   
