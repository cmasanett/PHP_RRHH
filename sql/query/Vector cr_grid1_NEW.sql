SELECT 
    p.id,
    p.descripcion,
    pp.valor AS contenido,
    pp.valor AS contant,
    pp.id AS pp_id,
    vp.solo_lectura,
    p.tipo_de_campo
--     vpl.id AS vplId,
--     vpl.valor_posible AS vplValorPosible,
--     vpl.significado AS vplSignificado
FROM
    zend_php_demo.n7_ppd_l pp
        INNER JOIN
    zend_php_demo.n7_vistas_propiedades_l vp ON vp.propiedad_id = pp.propiedad_id
        INNER JOIN
    zend_php_demo.n7_propiedades_l p ON p.id = vp.propiedad_id
        INNER JOIN
    zend_php_demo.n7_vistas_legajos v ON v.id = vp.formulario_id
--         LEFT JOIN
--     zend_php_demo.n7_valores_posibles_legajos vpl ON vpl.id = vp.propiedad_id
WHERE
    pp.objeto_id = 1
        AND v.descripcion = 'Alta de Legajo'
ORDER BY vp.orden;
