import fs from 'fs';
import path from 'path';

function walk(dir) {
    let results = [];
    if (!fs.existsSync(dir)) return results;
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else { 
            if (file.endsWith('.blade.php')) results.push(file);
        }
    });
    return results;
}

const files = walk('./resources/views');
let count = 0;
files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    // regex to find @vite([ ... ])
    const regex = /@vite\(\[([\s\S]*?)\]\)/g;
    let modified = false;
    let newContent = content.replace(regex, (match, inner) => {
        if (inner.includes('sidebar.css') || inner.includes('sidebar.js')) {
            return match; // already has sidebar
        }
        
        let items = inner.split(',').map(s => s.trim()).filter(s => s.length > 0);
        items.push("'resources/css/sidebar.css'");
        items.push("'resources/js/sidebar.js'");
        modified = true;
        return `@vite([${items.join(', ')}])`;
    });
    
    // Some lines may just have `@vite('resources/css/app.css')` without array (rare but possible), handle it just in case:
    const regexSingle = /@vite\('([^']+)'\)/g;
    newContent = newContent.replace(regexSingle, (match, inner) => {
        if (inner.includes('sidebar.css') || inner.includes('sidebar.js')) return match;
        modified = true;
        return `@vite(['${inner}', 'resources/css/sidebar.css', 'resources/js/sidebar.js'])`;
    });

    if (modified) {
        fs.writeFileSync(file, newContent);
        count++;
        console.log("Updated", file);
    }
});
console.log(`\nUpdated ${count} files in total.`);
