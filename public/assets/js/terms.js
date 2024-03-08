async function getRelatedTerms(term){
    /* key_words - async function - queries wikipedia for terms similar to the searched

        TODO: save the results in the database to avoid new queries and speed up the search

        args - string term - term to be searched

        return - string array - related search terms
    */

    if( !term ) return null;

    const conf = {method: "GET"};
    let request, data;

    request = await fetch("https://en.wikipedia.org/w/api.php?origin=*&action=query&list=search&srsearch="+term+"&srlimit=1&format=json", conf);

    data = await request.json();

    const pageid = data.query.search[0].pageid;

    request = await fetch("https://en.wikipedia.org/w/api.php?origin=*&action=parse&prop=sections&format=json&pageid="+pageid, conf);

    data = await request.json();

    sections = data.parse.sections;

    let index = -1;

    for(let i = 0; i < sections.length; i++){
        if( sections[i].anchor.match(/See\_also/) ){
            index = sections[i].index;
            break;
        }
    }

    if( index < 0 ) return null;

    request = await fetch("https://en.wikipedia.org/w/api.php?origin=*&action=parse&prop=links&format=json&pageid="+pageid+"&section="+index, conf);

    data = await request.json();

    terms = data.parse.links.map( i => i["*"].replace(/.*\:/, "") );

    return terms;
}

/*
Example of use
terms = await getRelatedTerms("systematic review");
*/
