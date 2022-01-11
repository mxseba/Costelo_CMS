function calculateScaledFontSize(width, height) {
	return Math.round(Math.max(12, Math.min(Math.min(width, height) * 0.75, (0.75 * Math.max(width, height)) / 5)));
}


function placeholder(source, width, height) {
	const fontSize = calculateScaledFontSize(width, height);
	const backgroundColor = 'eeeeee';
	const fontColor = 'aaaaaa';
	
	source.src = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 "+width+" "+height+"' width='"+width+"' height='"+height+"'%3E%3Crect width='"+width+"' height='"+height+"' fill='%23"+backgroundColor+"'%3E%3C/rect%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='monospace' font-size='"+fontSize+"px' fill='%2"+fontColor+"'%3E"+width+"x"+height+"%3C/text%3E%3C/svg%3E";
	console.log(source.src);
	source.onerror = "";
    return true;
}