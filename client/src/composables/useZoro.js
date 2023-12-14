export default function useZoro() {

    const slice = (file) => {
        
        let size = 500000,
            chunks = Math.ceil(file.size / size);
        let chunked_array = [];
        for (let i = 0; i < chunks; i++) {
            chunked_array.push(
                file.slice(i * size, Math.min(i * size + size, file.size), file.type)
            );
        }
        return chunked_array;
    }


    return {
        slice
    }
}